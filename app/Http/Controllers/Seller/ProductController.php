<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = auth()->user()->products()->latest()->get();
        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('seller.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_id' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_id' => 'required|string',
            'description_en' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = 'assets/products/product-placeholder.jpg';
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $imagePath = 'storage/' . $imagePath;
        }

        auth()->user()->products()->create([
            'title_id' => $validated['title_id'],
            'title_en' => $validated['title_en'],
            'description_id' => $validated['description_id'],
            'description_en' => $validated['description_en'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'category_id' => $validated['category_id'] ?? null,
            'images' => [$imagePath, $imagePath, $imagePath, $imagePath],
            'address' => auth()->user()->city ?? 'Indonesia',
        ]);

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(\App\Models\Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            abort(403);
        }
        $categories = \App\Models\Category::all();
        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, \App\Models\Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title_id' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_id' => 'required|string',
            'description_en' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $imagePath = 'storage/' . $imagePath;
            $product->images = [$imagePath, $imagePath, $imagePath, $imagePath];
        }

        $product->update([
            'title_id' => $validated['title_id'],
            'title_en' => $validated['title_en'],
            'description_id' => $validated['description_id'],
            'description_en' => $validated['description_en'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'category_id' => $validated['category_id'] ?? null,
        ]);

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(\App\Models\Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            abort(403);
        }

        $product->delete();
        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
