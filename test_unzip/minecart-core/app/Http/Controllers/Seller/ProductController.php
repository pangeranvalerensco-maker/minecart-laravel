<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('user_id', Auth::id())->latest()->get();
        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('seller.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_id' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'condition' => 'required|in:baru,bekas',
            'weight' => 'required|integer|min:1',
            'sku' => 'nullable|string|max:100',
            'description_id' => 'required|string',
            'description_en' => 'required|string',
            'images' => 'required|array|min:1|max:3',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imagePaths[] = $file->store('products', 'public');
            }
        }
        $images = $imagePaths;

        Product::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title_id' => $request->title_id,
            'title_en' => $request->title_en,
            'description_id' => $request->description_id,
            'description_en' => $request->description_en,
            'price' => $request->price,
            'stock' => $request->stock,
            'condition' => $request->condition,
            'weight' => $request->weight,
            'sku' => $request->sku,
            'images' => $images,
            'address' => Auth::user()->address ?? 'Toko Online',
            'is_recommended' => false,
        ]);

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        if ($product->user_id !== Auth::id()) abort(403);
        $categories = Category::all();
        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->user_id !== Auth::id()) abort(403);

        $request->validate([
            'title_id' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'condition' => 'required|in:baru,bekas',
            'weight' => 'required|integer|min:1',
            'sku' => 'nullable|string|max:100',
            'description_id' => 'required|string',
            'description_en' => 'required|string',
            'images' => 'nullable|array|max:3',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except(['images', '_token', '_method']);

        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $file) {
                $imagePaths[] = $file->store('products', 'public');
            }
            $data['images'] = $imagePaths;
        }

        $product->update($data);

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($product->user_id !== Auth::id()) abort(403);
        $product->delete();
        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
