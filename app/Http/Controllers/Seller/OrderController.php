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
}
