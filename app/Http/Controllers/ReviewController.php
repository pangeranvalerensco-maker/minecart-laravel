<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function create(OrderItem $orderItem)
    {
        // Ensure user owns the order
        if ($orderItem->order->user_id !== auth()->id()) {
            abort(403);
        }

        // Ensure order is completed
        if ($orderItem->order->status !== 'completed') {
            return redirect()->route('account.orders')->with('error', 'Pesanan belum selesai.');
        }

        // Ensure not already reviewed
        if ($orderItem->review()->exists()) {
            return redirect()->route('account.orders')->with('error', 'Item ini sudah diulas.');
        }

        return view('reviews.create', compact('orderItem'));
    }

    public function store(Request $request, OrderItem $orderItem)
    {
        // Ensure user owns the order
        if ($orderItem->order->user_id !== auth()->id()) {
            abort(403);
        }

        // Ensure order is completed
        if ($orderItem->order->status !== 'completed') {
            return redirect()->route('account.orders')->with('error', 'Pesanan belum selesai.');
        }

        // Ensure not already reviewed
        if ($orderItem->review()->exists()) {
            return redirect()->route('account.orders')->with('error', 'Item ini sudah diulas.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reviews', 'public');
        }

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $orderItem->product_id,
            'order_item_id' => $orderItem->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('account.orders')->with('success', 'Ulasan berhasil disimpan!');
    }
}
