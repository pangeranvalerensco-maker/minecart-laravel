<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index()
    {
        $recommendedProducts = Product::with('category')
            ->where('is_recommended', true)
            ->limit(12) // Increased limit to show more items
            ->get();
            
        $flashSaleProducts = Product::with('category')
            ->where('is_flash_sale', true)
            ->where('flash_sale_stock', '>', 0)
            ->where(function($q) {
                $q->whereNull('flash_sale_start')->orWhere('flash_sale_start', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('flash_sale_end')->orWhere('flash_sale_end', '>=', now());
            })
            ->limit(8)
            ->get();
            
        $categories = \App\Models\Category::all();

        return view('home', compact('recommendedProducts', 'categories', 'flashSaleProducts'));
    }
}
