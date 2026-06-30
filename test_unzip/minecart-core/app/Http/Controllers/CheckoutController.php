<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Coupon;
use App\Services\ShippingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;

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
                    $itemSubtotal = $product->current_price * $quantity;
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
     * Calculate shipping cost via AJAX.
     */
    public function calculateShipping(Request $request)
    {
        $city = $request->input('city');
        $courier = $request->input('courier', 'jne');

        if (empty($city)) {
            return response()->json(['shipping_cost' => 0]);
        }

        $cart = session()->get('cart', []);
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $cartItemsForShipping = [];
        foreach ($cart as $productId => $item) {
            if (isset($products[$productId])) {
                $cartItemsForShipping[] = [
                    'product' => $products[$productId],
                    'quantity' => $item['quantity'],
                ];
            }
        }

        $shippingService = new \App\Services\RajaOngkirService();
        $cost = $shippingService->calculateForOrder($cartItemsForShipping, $city, $courier);

        return response()->json(['shipping_cost' => $cost]);
    }

    /**
     * Verify a coupon code via AJAX.
     */
    public function checkCoupon(Request $request)
    {
        $code = $request->input('code');
        if (!$code) {
            return response()->json(['valid' => false, 'message' => 'Kode kupon tidak boleh kosong.']);
        }

        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return response()->json(['valid' => false, 'message' => 'Kode kupon tidak ditemukan.']);
        }

        if (!$coupon->isValid()) {
            return response()->json(['valid' => false, 'message' => 'Kode kupon tidak valid atau sudah kadaluarsa.']);
        }

        return response()->json([
            'valid' => true,
            'message' => 'Kupon berhasil diterapkan.',
            'coupon' => $coupon
        ]);
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
            'payment_method' => 'required|in:xendit,cod',
            'courier' => 'required|in:jne,pos,tiki,jnt',
            'coupon_code' => 'nullable|string'
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

                    $itemSubtotal = $product->current_price * $quantity;
                    $subtotal += $itemSubtotal;

                    $orderItems[] = [
                        'product_id' => $product->id,
                        'product_name' => $product->title_id,
                        'price' => $product->current_price,
                        'quantity' => $quantity,
                        'subtotal' => $itemSubtotal,
                    ];

                    $cartItemsForShipping[] = [
                        'product' => $product,
                        'quantity' => $quantity,
                    ];
                }

                // Calculate shipping server-side
                $shippingService = new \App\Services\RajaOngkirService();
                $shippingCost = $shippingService->calculateForOrder($cartItemsForShipping, $validated['city'], $validated['courier']);
                
                $discountAmount = 0;
                $couponId = null;
                
                if (!empty($validated['coupon_code'])) {
                    $coupon = Coupon::where('code', $validated['coupon_code'])->first();
                    if ($coupon && $coupon->isValid()) {
                        $discountAmount = $coupon->calculateDiscount($subtotal);
                        $couponId = $coupon->id;
                        
                        // Increment used count
                        $coupon->increment('used_count');
                    }
                }

                $total = $subtotal + $shippingCost - $discountAmount;
                if ($total < 0) $total = 0;

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
                    'coupon_id' => $couponId,
                    'discount_amount' => $discountAmount,
                    'total' => $total,
                    'payment_method' => $validated['payment_method'],
                    'payment_status' => 'pending', // Set to pending for xendit
                    'status' => 'processing',
                ]);

                // Create order items and decrease stock
                foreach ($orderItems as $itemData) {
                    OrderItem::create(array_merge($itemData, [
                        'order_id' => $order->id,
                        'shipping_courier' => $validated['courier'],
                    ]));

                    // Decrease product stock
                    $product = $products[$itemData['product_id']];
                    $product->decrement('stock', $itemData['quantity']);
                }
                
                return $order;
            });

                // Transaction succeeded: clear cart and store last order ID
                session()->forget('cart');
                session()->put('last_order_id', $order->id);
                
                if ($order->payment_method === 'xendit') {
                    try {
                        $secretKey = env('XENDIT_SECRET_KEY');
                        if (empty($secretKey)) {
                            // Mock Xendit response for portfolio testing if key is empty
                            $order->xendit_invoice_id = 'mock_inv_' . Str::random(10);
                            $order->xendit_invoice_url = route('checkout.success'); 
                            $order->save();
                            return redirect($order->xendit_invoice_url)->with('success', 'Pesanan berhasil dibuat (Mode Simulasi Xendit)');
                        }

                        Configuration::setXenditKey($secretKey);
                        $apiInstance = new InvoiceApi();
                        $create_invoice_request = new CreateInvoiceRequest([
                            'external_id' => $order->order_number,
                            'description' => 'Pembayaran pesanan ' . $order->order_number,
                            'amount' => $order->total,
                            'invoice_duration' => 86400,
                            'customer' => [
                                'given_names' => $order->fullname,
                                'mobile_number' => $order->phone,
                            ],
                            'success_redirect_url' => route('checkout.success'),
                            'failure_redirect_url' => route('home')
                        ]);
                        $result = $apiInstance->createInvoice($create_invoice_request);
                        $order->xendit_invoice_id = $result['id'];
                        $order->xendit_invoice_url = $result['invoice_url'];
                        $order->save();
                        
                        return redirect($order->xendit_invoice_url);
                    } catch (\Exception $e) {
                        Log::error('Xendit Invoice Creation failed: ' . $e->getMessage(), ['exception' => $e]);
                        return redirect()->route('checkout.success')->with('error', 'Gagal membuat tagihan Xendit. Silakan hubungi admin.');
                    }
                }

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
