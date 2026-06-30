<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function create()
    {
        if (auth()->user()->is_seller) {
            return redirect()->route('seller.products.index')->with('success', 'Anda sudah memiliki toko.');
        }

        return view('store.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
        ]);

        $user = auth()->user();
        $user->is_seller = true;
        $user->store_name = $request->store_name;
        $user->save();

        return redirect()->route('seller.products.index')->with('success', 'Toko Anda berhasil dibuka!');
    }
}
