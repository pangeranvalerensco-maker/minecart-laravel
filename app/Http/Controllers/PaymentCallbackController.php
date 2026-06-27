<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentCallbackController extends Controller
{
    public function receive(\Illuminate\Http\Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            $order = \App\Models\Order::where('order_number', $request->order_id)->first();
            if ($order) {
                if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                    $order->payment_status = 'paid';
                } elseif ($request->transaction_status == 'cancel' || $request->transaction_status == 'deny' || $request->transaction_status == 'expire') {
                    $order->payment_status = 'failed';
                    $order->status = 'cancelled';
                }
                $order->save();
            }
        }
        
        return response()->json(['message' => 'ok']);
    }
}
