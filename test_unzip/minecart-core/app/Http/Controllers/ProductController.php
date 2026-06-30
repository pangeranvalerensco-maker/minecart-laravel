<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Product::with('category');

        // Search filter
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('title_id', 'like', '%' . $search . '%')
                  ->orWhere('title_en', 'like', '%' . $search . '%')
                  ->orWhere('description_id', 'like', '%' . $search . '%');
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $categorySlug = $request->input('category');
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // Price filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        // Sorting
        $sort = $request->input('sort', 'default');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('title_id', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('title_id', 'desc');
                break;
            case 'stock_desc':
                $query->orderBy('stock', 'desc');
                break;
            case 'stock_asc':
                $query->orderBy('stock', 'asc');
                break;
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $products = $query->paginate(12)->withQueryString();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load('reviews.user');
        
        $relatedProducts = collect();

        if ($product->category_id) {
            $relatedProducts = Product::with('category')
                ->where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->limit(4)
                ->get();
        }

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
