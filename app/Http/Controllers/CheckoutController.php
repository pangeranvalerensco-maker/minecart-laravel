<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\ShippingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    /**
     * Display the checkout form.
     */
    public function index()
    {
        /** @var array $cart */
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong. Tambahkan produk terlebih dahulu.');
        }

        // Only authenticated users can checkout
        if (!Auth::check()) {
            return redirect()->guest(route('login'))->with('warning', 'Silakan masuk terlebih dahulu untuk melakukan checkout.');
        }

        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $cartItems = [];
        $subtotal = 0;
        $totalItems = 0;

        foreach ($cart as $productId => $item) {
            if (isset($products[$productId])) {
                $product = $products[$productId];
                $quantity = $item['quantity'];

                // Clamp to available stock
                if ($quantity > $product->stock) {
                    $quantity = $product->stock;
                }

                if ($quantity > 0) {
                    $itemSubtotal = $product->price * $quantity;
                    $subtotal += $itemSubtotal;
                    $totalItems += $quantity;

                    $cartItems[] = [
                        'product' => $product,
                        'quantity' => $quantity,
                        'subtotal' => $itemSubtotal,
                    ];
                }
            }
        }

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada produk valid di keranjang.');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        return view('checkout.index', compact('cartItems', 'subtotal', 'totalItems', 'user'));
    }

    /**
     * Process the checkout and create an order transactionally.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:150',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:1000',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'courier_note' => 'nullable|string|max:500',
            'payment_method' => 'required|in:bca_va,mandiri_va,gopay,cod',
        ]);

        /** @var array $cart */
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        try {
            $order = DB::transaction(function () use ($validated, $cart) {
                $productIds = array_keys($cart);

                // Lock products for update to prevent race conditions
                // (lockForUpdate is not supported by SQLite, so skip it in testing)
                $query = Product::whereIn('id', $productIds);
                if (DB::connection()->getDriverName() !== 'sqlite') {
                    $query->lockForUpdate();
                }
                $products = $query->get()->keyBy('id');

                $orderItems = [];
                $subtotal = 0;
                $cartItemsForShipping = [];

                foreach ($cart as $productId => $item) {
                    if (!isset($products[$productId])) {
                        throw new \RuntimeException('Produk dengan ID ' . $productId . ' tidak ditemukan.');
                    }

                    $product = $products[$productId];
                    $quantity = $item['quantity'];

                    if ($quantity < 1) {
                        throw new \RuntimeException('Jumlah produk "' . $product->title_id . '" tidak valid.');
                    }

                    if ($product->stock < $quantity) {
                        throw new \RuntimeException('Stok produk "' . $product->title_id . '" tidak mencukupi. Tersisa ' . $product->stock . ' item.');
                    }

                    $itemSubtotal = $product->price * $quantity;
                    $subtotal += $itemSubtotal;

                    $orderItems[] = [
                        'product_id' => $product->id,
                        'product_name' => $product->title_id,
                        'price' => $product->price,
                        'quantity' => $quantity,
                        'subtotal' => $itemSubtotal,
                    ];

                    $cartItemsForShipping[] = [
                        'product' => $product,
                        'quantity' => $quantity,
                    ];
                }

                // Calculate shipping server-side
                $shippingService = new ShippingService();
                $shippingCost = $shippingService->calculateForOrder($cartItemsForShipping, $validated['city']);
                $total = $subtotal + $shippingCost;

                // Generate unique order number: MCT-YYYYMMDD-XXXXXX
                $orderNumber = 'MCT-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));

                // Create the order
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'order_number' => $orderNumber,
                    'fullname' => $validated['fullname'],
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                    'city' => $validated['city'],
                    'postal_code' => $validated['postal_code'],
                    'courier_note' => $validated['courier_note'] ?? null,
                    'subtotal' => $subtotal,
                    'shipping_cost' => $shippingCost,
                    'total' => $total,
                    'payment_method' => $validated['payment_method'],
                    'payment_status' => 'pending', // Set to pending for midtrans
                    'status' => 'processing',
                ]);

                // Create order items and decrease stock
                foreach ($orderItems as $itemData) {
                    OrderItem::create(array_merge($itemData, [
                        'order_id' => $order->id,
                    ]));

                    // Decrease product stock
                    $product = $products[$itemData['product_id']];
                    $product->decrement('stock', $itemData['quantity']);
                }
                
                // Configure Midtrans
                Config::$serverKey = config('midtrans.server_key');
                Config::$isProduction = config('midtrans.is_production');
                Config::$isSanitized = config('midtrans.is_sanitized');
                Config::$is3ds = config('midtrans.is_3ds');

                $params = [
                    'transaction_details' => [
                        'order_id' => $order->order_number,
                        'gross_amount' => $order->total,
                    ],
                    'customer_details' => [
                        'first_name' => $order->fullname,
                        'email' => Auth::user()->email,
                        'phone' => $order->phone,
                    ],
                ];

                try {
                    if (app()->environment('testing')) {
                        $snapToken = 'test_snap_token_' . Str::random(10);
                    } else {
                        $snapToken = Snap::getSnapToken($params);
                    }
                    $order->snap_token = $snapToken;
                    $order->save();
                } catch (\Exception $e) {
                    Log::error('Midtrans Snap Error: ' . $e->getMessage());
                    throw new \RuntimeException('Gagal membuat token pembayaran. Silakan coba lagi.');
                }

                return $order;
            });

            // Transaction succeeded: clear cart and store last order ID
            session()->forget('cart');
            session()->put('last_order_id', $order->id);

            return redirect()->route('checkout.success')->with('success', 'Pesanan berhasil dibuat!');
        } catch (\RuntimeException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Checkout failed: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
        }
    }

    /**
     * Display the order success page.
     */
    public function success()
    {
        $orderId = session()->get('last_order_id');

        if (!$orderId) {
            return redirect()->route('home')->with('error', 'Tidak ada pesanan terbaru.');
        }

        $order = Order::with('items')->find($orderId);

        if (!$order) {
            return redirect()->route('home')->with('error', 'Pesanan tidak ditemukan.');
        }

        return view('checkout.success', compact('order'));
    }
}
