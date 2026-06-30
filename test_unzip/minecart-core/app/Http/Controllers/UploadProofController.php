<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UploadProofController extends Controller
{
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->payment_method !== 'manual_transfer') {
            return redirect()->route('account.orders')->with('error', 'Pesanan ini tidak menggunakan transfer manual.');
        }

        return view('checkout.upload_proof', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('proofs', 'public');
            $order->payment_proof = $path;
            $order->payment_status = 'pending_verification';
            $order->save();
        }

        return redirect()->route('account.orders')->with('success', 'Bukti transfer berhasil diunggah. Menunggu verifikasi penjual.');
    }
}
