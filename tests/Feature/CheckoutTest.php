<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Services\ShippingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Helper: create a category and a product with the given attributes.
     */
    private function createProduct(array $overrides = []): Product
    {
        $category = Category::firstOrCreate(
            ['slug' => 'test-cat'],
            ['name' => 'Test Category']
        );

        return Product::create(array_merge([
            'category_id' => $category->id,
            'title_id' => 'Produk Test',
            'title_en' => 'Test Product',
            'description_id' => 'Deskripsi test',
            'description_en' => 'Test description',
            'price' => 100000,
            'stock' => 10,
            'images' => ['assets/products/product-1.jpg'],
            'seller_name' => 'Test Seller',
            'address' => 'Jl. Test No. 1, Bandung, Jawa Barat',
            'is_recommended' => false,
        ], $overrides));
    }

    /**
     * Helper: put product(s) in the session cart.
     */
    private function seedCart(array $items): void
    {
        $cart = [];
        foreach ($items as $item) {
            $cart[$item['product_id']] = [
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
            ];
        }
        session()->put('cart', $cart);
    }

    // ---------------------------------------------------------------
    // Checkout Page (GET /checkout)
    // ---------------------------------------------------------------

    public function test_checkout_page_redirects_when_cart_empty(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/checkout');
        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('error');
    }

    public function test_checkout_page_renders_with_items_in_cart(): void
    {
        $product = $this->createProduct();
        $this->seedCart([['product_id' => $product->id, 'quantity' => 2]]);

        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/checkout');
        $response->assertStatus(200);
        $response->assertSee('Checkout');
        $response->assertSee('Produk Test');
        $response->assertSee('Rp 200.000'); // 100000 * 2
    }

    // ---------------------------------------------------------------
    // Checkout Store (POST /checkout)
    // ---------------------------------------------------------------

    public function test_checkout_store_creates_order_and_reduces_stock(): void
    {
        $product = $this->createProduct(['stock' => 10, 'price' => 50000]);
        $this->seedCart([['product_id' => $product->id, 'quantity' => 3]]);

        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/checkout', [
            'fullname' => 'John Doe',
            'phone' => '08123456789',
            'address' => 'Jl. Merdeka No. 1',
            'city' => 'Bandung',
            'postal_code' => '40123',
            'courier_note' => 'Jangan dibanting',
            'payment_method' => 'bca_va',
        ]);

        $response->assertRedirect(route('checkout.success'));

        // Assert order was created
        $this->assertDatabaseCount('orders', 1);
        $order = Order::first();
        $this->assertNotNull($order);
        $this->assertStringStartsWith('MCT-', $order->order_number);
        $this->assertEquals('John Doe', $order->fullname);
        $this->assertEquals('08123456789', $order->phone);
        $this->assertEquals('Bandung', $order->city);
        $this->assertEquals(150000, $order->subtotal); // 50000 * 3
        $this->assertEquals('bca_va', $order->payment_method);
        $this->assertEquals('pending', $order->payment_status);
        $this->assertEquals('processing', $order->status);

        // Assert shipping cost is calculated server-side (same city = 9000)
        $this->assertEquals(9000, $order->shipping_cost);
        $this->assertEquals(159000, $order->total); // 150000 + 9000

        // Assert order item was created
        $this->assertDatabaseCount('order_items', 1);
        $orderItem = OrderItem::first();
        $this->assertEquals($product->id, $orderItem->product_id);
        $this->assertEquals('Produk Test', $orderItem->product_name);
        $this->assertEquals(50000, $orderItem->price);
        $this->assertEquals(3, $orderItem->quantity);
        $this->assertEquals(150000, $orderItem->subtotal);

        // Assert stock was reduced
        $product->refresh();
        $this->assertEquals(7, $product->stock); // 10 - 3

        // Assert cart was cleared
        $this->assertFalse(session()->has('cart'));

        // Assert last_order_id was stored in session
        $this->assertEquals($order->id, session('last_order_id'));
    }

    public function test_checkout_store_fails_when_stock_insufficient(): void
    {
        $product = $this->createProduct(['stock' => 2, 'price' => 50000]);
        $this->seedCart([['product_id' => $product->id, 'quantity' => 5]]);

        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/checkout', [
            'fullname' => 'Jane Doe',
            'phone' => '08123456789',
            'address' => 'Jl. Test No. 1',
            'city' => 'Jakarta',
            'postal_code' => '10000',
            'payment_method' => 'gopay',
        ]);

        // Should redirect back with error
        $response->assertRedirect();
        $response->assertSessionHas('error');

        // No order should be created
        $this->assertDatabaseCount('orders', 0);

        // Stock should NOT be changed
        $product->refresh();
        $this->assertEquals(2, $product->stock);
    }

    public function test_checkout_store_fails_with_empty_cart(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/checkout', [
            'fullname' => 'Jane Doe',
            'phone' => '08123456789',
            'address' => 'Jl. Test No. 1',
            'city' => 'Jakarta',
            'postal_code' => '10000',
            'payment_method' => 'cod',
        ]);

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_checkout_store_validates_required_fields(): void
    {
        $product = $this->createProduct();
        $this->seedCart([['product_id' => $product->id, 'quantity' => 1]]);

        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/checkout', []);

        $response->assertSessionHasErrors([
            'fullname', 'phone', 'address', 'city', 'postal_code', 'payment_method',
        ]);

        $this->assertDatabaseCount('orders', 0);
    }

    public function test_checkout_store_validates_payment_method(): void
    {
        $product = $this->createProduct();
        $this->seedCart([['product_id' => $product->id, 'quantity' => 1]]);

        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/checkout', [
            'fullname' => 'Jane Doe',
            'phone' => '08123456789',
            'address' => 'Jl. Test No. 1',
            'city' => 'Jakarta',
            'postal_code' => '10000',
            'payment_method' => 'bitcoin', // invalid
        ]);

        $response->assertSessionHasErrors(['payment_method']);
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_checkout_store_with_multiple_products(): void
    {
        $productA = $this->createProduct([
            'title_id' => 'Produk A',
            'price' => 100000,
            'stock' => 5,
            'address' => 'Jl. Test, Bandung, Jawa Barat',
        ]);
        $productB = $this->createProduct([
            'title_id' => 'Produk B',
            'price' => 200000,
            'stock' => 3,
            'address' => 'Jl. Test, Jakarta, DKI Jakarta',
        ]);

        $this->seedCart([
            ['product_id' => $productA->id, 'quantity' => 2], // subtotal = 200,000
            ['product_id' => $productB->id, 'quantity' => 1], // subtotal = 200,000
        ]);

        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/checkout', [
            'fullname' => 'Multi Buyer',
            'phone' => '08123456789',
            'address' => 'Jl. Merdeka No. 1',
            'city' => 'Bandung',
            'postal_code' => '40123',
            'payment_method' => 'mandiri_va',
        ]);

        $response->assertRedirect(route('checkout.success'));

        $order = Order::first();
        $this->assertEquals(400000, $order->subtotal); // 200000 + 200000

        // Shipping: Bandung→Bandung = same city (9000), Jakarta→Bandung = inter-province (25000)
        $this->assertEquals(34000, $order->shipping_cost); // 9000 + 25000
        $this->assertEquals(434000, $order->total);

        $this->assertDatabaseCount('order_items', 2);

        // Stock reduced
        $productA->refresh();
        $productB->refresh();
        $this->assertEquals(3, $productA->stock); // 5 - 2
        $this->assertEquals(2, $productB->stock); // 3 - 1
    }

    public function test_checkout_store_success_without_courier_note(): void
    {
        $product = $this->createProduct(['stock' => 5, 'price' => 50000]);
        $this->seedCart([['product_id' => $product->id, 'quantity' => 1]]);

        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/checkout', [
            'fullname' => 'No Note Buyer',
            'phone' => '08123456789',
            'address' => 'Jl. Tanpa Catatan No. 1',
            'city' => 'Bandung',
            'postal_code' => '40123',
            'payment_method' => 'cod',
            // 'courier_note' is intentionally missing
        ]);

        $response->assertRedirect(route('checkout.success'));

        $this->assertDatabaseCount('orders', 1);
        $order = Order::first();
        $this->assertEquals('No Note Buyer', $order->fullname);
        $this->assertNull($order->courier_note);
    }

    // ---------------------------------------------------------------
    // Success Page (GET /checkout/success)
    // ---------------------------------------------------------------

    public function test_success_page_redirects_when_no_order(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/checkout/success');
        $response->assertRedirect(route('home'));
    }

    public function test_success_page_renders_with_valid_order(): void
    {
        $product = $this->createProduct(['stock' => 10, 'price' => 50000]);

        // Create the order directly in DB
        $order = Order::create([
            'order_number' => 'MCT-20260619-AAAAAA',
            'fullname' => 'Success Viewer',
            'phone' => '08123456789',
            'address' => 'Jl. Test',
            'city' => 'Bandung',
            'postal_code' => '40123',
            'subtotal' => 100000,
            'shipping_cost' => 9000,
            'total' => 109000,
            'payment_method' => 'gopay',
            'payment_status' => 'paid',
            'status' => 'processing',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => 'Produk Test',
            'price' => 50000,
            'quantity' => 2,
            'subtotal' => 100000,
        ]);

        $user = User::factory()->create();
        $response = $this->actingAs($user)->withSession(['last_order_id' => $order->id])
            ->get('/checkout/success');

        $response->assertStatus(200);
        $response->assertSee('Transaksi Berhasil');
        $response->assertSee('MCT-20260619-AAAAAA');
        $response->assertSee('Success Viewer');
        $response->assertSee('Produk Test');
    }

    // ---------------------------------------------------------------
    // ShippingService Unit Tests
    // ---------------------------------------------------------------

    public function test_shipping_same_city(): void
    {
        $service = new ShippingService();
        $cost = $service->calculateForProduct('Jl. Test, Bandung, Jawa Barat', 'Bandung');
        $this->assertEquals(ShippingService::SAME_CITY_COST, $cost);
    }

    public function test_shipping_same_province(): void
    {
        $service = new ShippingService();
        $cost = $service->calculateForProduct('Jl. Test, Bandung, Jawa Barat', 'Bogor');
        $this->assertEquals(ShippingService::SAME_PROVINCE_COST, $cost);
    }

    public function test_shipping_inter_province(): void
    {
        $service = new ShippingService();
        $cost = $service->calculateForProduct('Jl. Test, Bandung, Jawa Barat', 'Surabaya');
        $this->assertEquals(ShippingService::INTER_PROVINCE_COST, $cost);
    }

    public function test_shipping_case_insensitive(): void
    {
        $service = new ShippingService();
        $cost = $service->calculateForProduct('Jl. Test, Bandung, Jawa Barat', 'bandung');
        $this->assertEquals(ShippingService::SAME_CITY_COST, $cost);
    }

    public function test_shipping_order_calculation_multiple_origins(): void
    {
        $service = new ShippingService();

        $productA = new Product();
        $productA->address = 'Jl. Test, Bandung, Jawa Barat';

        $productB = new Product();
        $productB->address = 'Jl. Test, Jakarta, DKI Jakarta';

        $cartItems = [
            ['product' => $productA, 'quantity' => 2],
            ['product' => $productB, 'quantity' => 1],
        ];

        $total = $service->calculateForOrder($cartItems, 'Bandung');
        // Bandung→Bandung = 9000 (same city), Jakarta→Bandung = 25000 (inter-province)
        $this->assertEquals(34000, $total);
    }
}
