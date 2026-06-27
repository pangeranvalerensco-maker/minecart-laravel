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
            ->limit(8)
            ->get();

        return view('home', compact('recommendedProducts'));
    }
}
