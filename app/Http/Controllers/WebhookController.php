<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function xendit(Request $request)
    {
        $xenditXCallbackToken = env('XENDIT_WEBHOOK_TOKEN');

        $reqHeaders = $request->headers->all();
        $xCallbackToken = $request->header('x-callback-token');

        if ($xenditXCallbackToken && $xCallbackToken !== $xenditXCallbackToken) {
            return response()->json(['message' => 'Invalid Callback Token'], 403);
        }

        $data = $request->all();
        
        Log::info('Xendit Webhook Received', ['data' => $data]);

        // Xendit Invoice Status: PENDING, PAID, SETTLED, EXPIRED
        if (isset($data['status']) && isset($data['external_id'])) {
            $order = Order::where('order_number', $data['external_id'])->first();

            if ($order) {
                if ($data['status'] === 'PAID' || $data['status'] === 'SETTLED') {
                    $order->payment_status = 'paid';
                    $order->status = 'processing';
                    $order->save();
                } else if ($data['status'] === 'EXPIRED') {
                    $order->payment_status = 'expired';
                    $order->status = 'cancelled';
                    $order->save();
                }
            }
        }

        return response()->json(['message' => 'Webhook received'], 200);
    }
}
