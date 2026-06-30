<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the shopping cart.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $cartItems = [];
        $subtotal = 0;
        $totalItems = 0;

        foreach ($cart as $productId => $item) {
            if (isset($products[$productId])) {
                $product = $products[$productId];
                
                // Adjust quantity if database stock has decreased since item was added
                $quantity = $item['quantity'];
                if ($quantity > $product->stock) {
                    $quantity = $product->stock;
                    $cart[$productId]['quantity'] = $quantity;
                    session()->put('cart', $cart);
                }

                if ($quantity > 0) {
                    $itemSubtotal = $product->current_price * $quantity;
                    $subtotal += $itemSubtotal;
                    $totalItems += $quantity;

                    $cartItems[] = [
                        'product' => $product,
                        'quantity' => $quantity,
                        'subtotal' => $itemSubtotal
                    ];
                }
            }
        }

        return view('cart.index', compact('cartItems', 'subtotal', 'totalItems'));
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request, Product $product)
    {
        $quantity = (int) $request->input('quantity', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }

        $cart = session()->get('cart', []);
        $currentQty = isset($cart[$product->id]) ? $cart[$product->id]['quantity'] : 0;

        if ($product->stock <= 0) {
            if ($request->expectsJson()) {
                $cartCount = 0;
                foreach ($cart as $item) {
                    $cartCount += $item['quantity'] ?? 0;
                }
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak cukup.',
                    'product_id' => $product->id,
                    'product_quantity' => $currentQty,
                    'cart_count' => $cartCount,
                    'stock' => 0
                ], 400);
            }
            return redirect()->back()->with('error', 'Stok tidak cukup.');
        }

        $newQty = $currentQty + $quantity;
        $isWarning = false;
        $message = 'Produk berhasil ditambahkan ke keranjang.';

        if ($newQty > $product->stock) {
            $newQty = $product->stock;
            $isWarning = true;
            $message = 'Stok tidak cukup. Jumlah produk dibatasi ke stok maksimal (' . $product->stock . ').';
        }

        $cart[$product->id] = [
            'product_id' => $product->id,
            'quantity' => $newQty
        ];
        session()->put('cart', $cart);

        $cartCount = 0;
        foreach ($cart as $item) {
            $cartCount += $item['quantity'] ?? 0;
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => !$isWarning,
                'message' => $message,
                'product_id' => $product->id,
                'product_quantity' => $newQty,
                'cart_count' => $cartCount,
                'stock' => $product->stock,
                'preview_html' => view('partials.cart_preview_items')->render()
            ]);
        }

        if ($isWarning) {
            return redirect()->back()->with('warning', $message);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Update the quantity of a product in the cart.
     */
    public function update(Request $request, Product $product)
    {
        $quantity = (int) $request->input('quantity');
        $isWarning = false;
        $message = 'Kuantitas produk berhasil diperbarui.';

        if ($quantity < 1) {
            $quantity = 1;
        }

        $cart = session()->get('cart', []);

        if ($quantity > $product->stock) {
            $quantity = $product->stock;
            $isWarning = true;
            $message = 'Stok tidak cukup. Jumlah produk dibatasi ke stok maksimal (' . $product->stock . ').';
        }

        $cart[$product->id] = [
            'product_id' => $product->id,
            'quantity' => $quantity
        ];
        session()->put('cart', $cart);

        // Recompute cart totals from database products
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $cartTotal = 0;
        $cartCount = 0;
        $itemSubtotal = 0;

        foreach ($cart as $pid => $item) {
            if (isset($products[$pid])) {
                $p = $products[$pid];
                $qty = $item['quantity'];

                // Safety sync with stock
                if ($qty > $p->stock) {
                    $qty = $p->stock;
                    $cart[$pid]['quantity'] = $qty;
                    session()->put('cart', $cart);
                }

                $sub = $p->current_price * $qty;
                $cartTotal += $sub;
                $cartCount += $qty;

                if ($pid == $product->id) {
                    $itemSubtotal = $sub;
                }
            }
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => !$isWarning,
                'message' => $message,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'item_subtotal' => $itemSubtotal,
                'cart_total' => $cartTotal,
                'cart_count' => $cartCount,
                'stock' => $product->stock
            ]);
        }

        if ($isWarning) {
            return redirect()->back()->with('warning', $message);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Remove a product from the cart.
     */
    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    /**
     * Clear the cart.
     */
    public function clear()
    {
        session()->forget('cart');

        return redirect()->back()->with('success', 'Keranjang belanja berhasil dikosongkan.');
    }
}
