<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        $sellerId = auth()->id();
        
        $orderItems = \App\Models\OrderItem::with(['order', 'product'])
            ->whereHas('product', function($query) use ($sellerId) {
                $query->where('user_id', $sellerId);
            })
            ->latest()
            ->get();

        return view('seller.orders.index', compact('orderItems'));
    }

    public function updateResi(\Illuminate\Http\Request $request, \App\Models\OrderItem $orderItem)
    {
        // Verify seller owns this item
        if ($orderItem->product->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'tracking_number' => 'required|string|max:100',
        ]);

        $orderItem->update([
            'tracking_number' => $request->tracking_number,
            'status' => 'shipped',
        ]);

        return back()->with('success', 'Nomor resi berhasil disimpan. Status menjadi Dikirim.');
    }

    public function verifyPayment(\Illuminate\Http\Request $request, \App\Models\Order $order)
    {
        // verify seller owns at least one item in this order
        $sellerId = auth()->id();
        $isSeller = $order->items()->whereHas('product', function($q) use ($sellerId) {
            $q->where('user_id', $sellerId);
        })->exists();

        if (!$isSeller) {
            abort(403);
        }

        $order->update([
            'payment_status' => 'paid',
            'status' => 'processing',
        ]);

        return back()->with('success', 'Pembayaran berhasil diverifikasi. Status pesanan berubah menjadi Diproses.');
    }
}
