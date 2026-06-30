<?php

namespace App\Http\Controllers;


class OrderController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $orders = \App\Models\Order::query()->with('items.product', 'items.review')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return view('account.orders', compact('orders'));
    }

    public function markCompleted(\App\Models\Order $order)
    {
        // Ensure user owns the order
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status === 'completed') {
            return back()->with('info', 'Pesanan ini sudah selesai.');
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($order) {
            $order->update(['status' => 'completed']);
            $order->items()->update(['status' => 'completed']);

            $commissionRate = \App\Models\Setting::where('key', 'platform_commission')->value('value') ?? 5; // Default 5%

            foreach ($order->items as $item) {
                if ($item->product && $item->product->user_id) {
                    $sellerId = $item->product->user_id;
                    $wallet = \App\Models\Wallet::firstOrCreate(['user_id' => $sellerId]);
                    
                    $subtotal = $item->subtotal;
                    $commission = ($subtotal * $commissionRate) / 100;
                    $sellerEarns = $subtotal - $commission;
                    
                    $wallet->balance += $sellerEarns;
                    $wallet->save();

                    \App\Models\WalletTransaction::create([
                        'wallet_id' => $wallet->id,
                        'type' => 'credit',
                        'amount' => $sellerEarns,
                        'description' => "Penjualan produk: {$item->product_name} (Komisi platform: {$commissionRate}%)",
                        'reference_id' => $order->id,
                    ]);
                }
            }
        });

        return back()->with('success', 'Pesanan telah diselesaikan. Terima kasih!');
    }
}
