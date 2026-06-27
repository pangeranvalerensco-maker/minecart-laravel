<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test that the homepage renders recommended products from the database.
     */
    public function test_homepage_shows_recommended_products(): void
    {
        // 1. Create a category
        $category = \App\Models\Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
        ]);

        // 2. Create products (one recommended, one not)
        $recommended = \App\Models\Product::create([
            'category_id' => $category->id,
            'title_id' => 'Produk Tes Rekomendasi',
            'title_en' => 'Recommended Test Product',
            'description_id' => 'Deskripsi rekomendasi',
            'description_en' => 'Recommended description',
            'price' => 100000,
            'stock' => 10,
            'images' => ['assets/products/product-1.jpg'],
            'seller_name' => 'Test Seller',
            'address' => 'Test Address',
            'is_recommended' => true,
        ]);

        $notRecommended = \App\Models\Product::create([
            'category_id' => $category->id,
            'title_id' => 'Produk Tes Biasa',
            'title_en' => 'Normal Test Product',
            'description_id' => 'Deskripsi biasa',
            'description_en' => 'Normal description',
            'price' => 50000,
            'stock' => 5,
            'images' => ['assets/products/product-2.jpg'],
            'seller_name' => 'Test Seller',
            'address' => 'Test Address',
            'is_recommended' => false,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);

        // Verify that the recommended product is rendered
        $response->assertSee('Produk Tes Rekomendasi');
        $response->assertSee('Rp 100.000');
        
        // Verify that the non-recommended product is NOT rendered
        $response->assertDontSee('Produk Tes Biasa');
    }

    /**
     * Test that the homepage shows an empty state when no recommended products exist.
     */
    public function test_homepage_shows_empty_state_when_no_recommended_products(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        
        // Verify the empty state text
        $response->assertSee('Tidak Ada Produk Rekomendasi');
    }

    /**
     * Test that the products catalog page can be accessed.
     */
    public function test_catalog_page_can_be_accessed(): void
    {
        $category = \App\Models\Category::create(['name' => 'Cat 1', 'slug' => 'cat-1']);
        \App\Models\Product::create([
            'category_id' => $category->id,
            'title_id' => 'Produk A',
            'title_en' => 'Product A',
            'description_id' => 'Desc A',
            'description_en' => 'Desc A',
            'price' => 150000,
            'stock' => 10,
            'images' => ['assets/products/product-1.jpg'],
            'seller_name' => 'Seller A',
            'address' => 'Addr A',
            'is_recommended' => false,
        ]);

        $response = $this->get('/products');
        $response->assertStatus(200);
        $response->assertSee('Produk A');
    }

    /**
     * Test that the products search functionality works.
     */
    public function test_catalog_search_works(): void
    {
        $category = \App\Models\Category::create(['name' => 'Cat 1', 'slug' => 'cat-1']);
        \App\Models\Product::create([
            'category_id' => $category->id,
            'title_id' => 'Jaket Denim Keren',
            'title_en' => 'Cool Denim Jacket',
            'description_id' => 'Desc Jaket',
            'description_en' => 'Desc Jacket',
            'price' => 150000,
            'stock' => 10,
            'images' => ['assets/products/product-1.jpg'],
            'seller_name' => 'Seller A',
            'address' => 'Addr A',
            'is_recommended' => false,
        ]);
        \App\Models\Product::create([
            'category_id' => $category->id,
            'title_id' => 'Keyboard Mekanikal',
            'title_en' => 'Mechanical Keyboard',
            'description_id' => 'Desc Keyboard',
            'description_en' => 'Desc Keyboard',
            'price' => 250000,
            'stock' => 5,
            'images' => ['assets/products/product-2.jpg'],
            'seller_name' => 'Seller B',
            'address' => 'Addr B',
            'is_recommended' => false,
        ]);

        $response = $this->get('/products?q=Jaket');
        $response->assertStatus(200);
        $response->assertSee('Jaket Denim Keren');
        $response->assertDontSee('Keyboard Mekanikal');
    }

    /**
     * Test that category filtering works.
     */
    public function test_catalog_category_filter_works(): void
    {
        $gaming = \App\Models\Category::create(['name' => 'Gaming', 'slug' => 'gaming']);
        $apparel = \App\Models\Category::create(['name' => 'Apparel', 'slug' => 'apparel']);

        \App\Models\Product::create([
            'category_id' => $gaming->id,
            'title_id' => 'Stik Game',
            'title_en' => 'Game Controller',
            'description_id' => 'Desc',
            'description_en' => 'Desc',
            'price' => 100000,
            'stock' => 10,
            'images' => ['assets/products/product-1.jpg'],
            'seller_name' => 'Seller A',
            'address' => 'Addr A',
            'is_recommended' => false,
        ]);
        \App\Models\Product::create([
            'category_id' => $apparel->id,
            'title_id' => 'Kaos Keren',
            'title_en' => 'Cool T-Shirt',
            'description_id' => 'Desc',
            'description_en' => 'Desc',
            'price' => 200000,
            'stock' => 5,
            'images' => ['assets/products/product-2.jpg'],
            'seller_name' => 'Seller B',
            'address' => 'Addr B',
            'is_recommended' => false,
        ]);

        $response = $this->get('/products?category=gaming');
        $response->assertStatus(200);
        $response->assertSee('Stik Game');
        $response->assertDontSee('Kaos Keren');
    }

    /**
     * Test that sorting works for price, name, and stock.
     */
    public function test_catalog_sorting_works(): void
    {
        $category = \App\Models\Category::create(['name' => 'Cat 1', 'slug' => 'cat-1']);
        
        \App\Models\Product::create([
            'category_id' => $category->id,
            'title_id' => 'Product A',
            'title_en' => 'Product A',
            'description_id' => 'Desc',
            'description_en' => 'Desc',
            'price' => 100000,
            'stock' => 10,
            'images' => ['assets/products/product-1.jpg'],
            'seller_name' => 'Seller A',
            'address' => 'Addr A',
            'is_recommended' => false,
        ]);
        \App\Models\Product::create([
            'category_id' => $category->id,
            'title_id' => 'Product B',
            'title_en' => 'Product B',
            'description_id' => 'Desc',
            'description_en' => 'Desc',
            'price' => 50000,
            'stock' => 20,
            'images' => ['assets/products/product-2.jpg'],
            'seller_name' => 'Seller B',
            'address' => 'Addr B',
            'is_recommended' => false,
        ]);

        // Price asc
        $response = $this->get('/products?sort=price_asc');
        $response->assertStatus(200);
        $response->assertSeeInOrder(['Product B', 'Product A']);

        // Price desc
        $response = $this->get('/products?sort=price_desc');
        $response->assertStatus(200);
        $response->assertSeeInOrder(['Product A', 'Product B']);

        // Name asc
        $response = $this->get('/products?sort=name_asc');
        $response->assertStatus(200);
        $response->assertSeeInOrder(['Product A', 'Product B']);

        // Name desc
        $response = $this->get('/products?sort=name_desc');
        $response->assertStatus(200);
        $response->assertSeeInOrder(['Product B', 'Product A']);

        // Stock desc
        $response = $this->get('/products?sort=stock_desc');
        $response->assertStatus(200);
        $response->assertSeeInOrder(['Product B', 'Product A']);

        // Stock asc
        $response = $this->get('/products?sort=stock_asc');
        $response->assertStatus(200);
        $response->assertSeeInOrder(['Product A', 'Product B']);
    }

    /**
     * Test that the product detail page can be accessed.
     */
    public function test_product_detail_page_can_be_accessed(): void
    {
        $category = \App\Models\Category::create(['name' => 'Cat 1', 'slug' => 'cat-1']);
        $user = \App\Models\User::factory()->create(['is_seller' => true, 'store_name' => 'Toko Varel']);

        $product = \App\Models\Product::create([
            'category_id' => $category->id,
            'user_id' => $user->id,
            'title_id' => 'Detail Product A',
            'title_en' => 'Detail Product A',
            'description_id' => 'Deskripsi detail produk A',
            'description_en' => 'English details A',
            'price' => 150000,
            'stock' => 10,
            'images' => ['assets/products/product-1.jpg'],
            'address' => 'Alamat Varel',
            'is_recommended' => false,
        ]);

        $response = $this->get('/products/' . $product->id);
        $response->assertStatus(200);
        $response->assertSee('Detail Product A');
        $response->assertSee('Deskripsi detail produk A');
        $response->assertSee('Toko Varel');
        $response->assertSee('Alamat Varel');
    }

    /**
     * Test that an invalid product ID returns 404.
     */
    public function test_invalid_product_detail_returns_404(): void
    {
        $response = $this->get('/products/999999');
        $response->assertStatus(404);
    }

    /**
     * Test that the cart page can be accessed.
     */
    public function test_cart_page_can_be_accessed(): void
    {
        $response = $this->get('/cart');
        $response->assertStatus(200);
        $response->assertSee('Keranjang Belanja');
    }

    /**
     * Test that a product can be added to the cart.
     */
    public function test_product_can_be_added_to_cart(): void
    {
        $category = \App\Models\Category::create(['name' => 'Cat 1', 'slug' => 'cat-1']);
        $product = \App\Models\Product::create([
            'category_id' => $category->id,
            'title_id' => 'Produk A',
            'title_en' => 'Product A',
            'description_id' => 'Desc A',
            'description_en' => 'Desc A',
            'price' => 10000,
            'stock' => 10,
            'images' => ['assets/products/product-1.jpg'],
            'seller_name' => 'Seller A',
            'address' => 'Addr A',
            'is_recommended' => false,
        ]);

        $user = \App\Models\User::factory()->create();
        $response = $this->actingAs($user)->post('/cart/add/' . $product->id, ['quantity' => 2]);
        $response->assertRedirect();
        
        $cart = session('cart');
        $this->assertNotNull($cart);
        $this->assertEquals(2, $cart[$product->id]['quantity']);
    }

    /**
     * Test that a product with 0 stock cannot be added to the cart.
     */
    public function test_out_of_stock_product_cannot_be_added_to_cart(): void
    {
        $category = \App\Models\Category::create(['name' => 'Cat 1', 'slug' => 'cat-1']);
        $product = \App\Models\Product::create([
            'category_id' => $category->id,
            'title_id' => 'Produk Habis',
            'title_en' => 'Out of stock',
            'description_id' => 'Desc',
            'description_en' => 'Desc',
            'price' => 10000,
            'stock' => 0,
            'images' => ['assets/products/product-1.jpg'],
            'seller_name' => 'Seller A',
            'address' => 'Addr A',
            'is_recommended' => false,
        ]);

        $user = \App\Models\User::factory()->create();
        $response = $this->actingAs($user)->post('/cart/add/' . $product->id, ['quantity' => 1]);
        $response->assertRedirect();
        $response->assertSessionHas('error', 'Stok tidak cukup.');

        $cart = session('cart');
        $this->assertTrue(empty($cart));
    }

    /**
     * Test that the quantity of a cart item can be updated.
     */
    public function test_cart_quantity_can_be_updated(): void
    {
        $category = \App\Models\Category::create(['name' => 'Cat 1', 'slug' => 'cat-1']);
        $product = \App\Models\Product::create([
            'category_id' => $category->id,
            'title_id' => 'Produk A',
            'title_en' => 'Product A',
            'description_id' => 'Desc A',
            'description_en' => 'Desc A',
            'price' => 10000,
            'stock' => 10,
            'images' => ['assets/products/product-1.jpg'],
            'seller_name' => 'Seller A',
            'address' => 'Addr A',
            'is_recommended' => false,
        ]);

        // Put in session first
        session()->put('cart', [
            $product->id => [
                'product_id' => $product->id,
                'quantity' => 1
            ]
        ]);

        $user = \App\Models\User::factory()->create();
        $response = $this->actingAs($user)->patch('/cart/update/' . $product->id, ['quantity' => 5]);
        $response->assertRedirect();

        $cart = session('cart');
        $this->assertEquals(5, $cart[$product->id]['quantity']);
    }

    /**
     * Test that cart quantity cannot exceed stock.
     */
    public function test_cart_quantity_cannot_exceed_stock(): void
    {
        $category = \App\Models\Category::create(['name' => 'Cat 1', 'slug' => 'cat-1']);
        $product = \App\Models\Product::create([
            'category_id' => $category->id,
            'title_id' => 'Produk A',
            'title_en' => 'Product A',
            'description_id' => 'Desc A',
            'description_en' => 'Desc A',
            'price' => 10000,
            'stock' => 5,
            'images' => ['assets/products/product-1.jpg'],
            'seller_name' => 'Seller A',
            'address' => 'Addr A',
            'is_recommended' => false,
        ]);

        // Attempt to add 10 (exceeds stock of 5)
        $response = $this->post('/cart/add/' . $product->id, ['quantity' => 10]);
        $response->assertRedirect();
        $response->assertSessionHas('warning');

        $cart = session('cart');
        $this->assertEquals(5, $cart[$product->id]['quantity']); // Limited to stock

        // Attempt to update to 12 (exceeds stock of 5)
        $user = \App\Models\User::factory()->create();
        $response = $this->actingAs($user)->patch('/cart/update/' . $product->id, ['quantity' => 12]);
        $response->assertRedirect();
        $response->assertSessionHas('warning');

        $cart = session('cart');
        $this->assertEquals(5, $cart[$product->id]['quantity']); // Limited to stock
    }

    /**
     * Test that an item can be removed from the cart.
     */
    public function test_item_can_be_removed_from_cart(): void
    {
        $category = \App\Models\Category::create(['name' => 'Cat 1', 'slug' => 'cat-1']);
        $product = \App\Models\Product::create([
            'category_id' => $category->id,
            'title_id' => 'Produk A',
            'title_en' => 'Product A',
            'description_id' => 'Desc A',
            'description_en' => 'Desc A',
            'price' => 10000,
            'stock' => 10,
            'images' => ['assets/products/product-1.jpg'],
            'seller_name' => 'Seller A',
            'address' => 'Addr A',
            'is_recommended' => false,
        ]);

        session()->put('cart', [
            $product->id => [
                'product_id' => $product->id,
                'quantity' => 2
            ]
        ]);

        $user = \App\Models\User::factory()->create();
        $response = $this->actingAs($user)->delete('/cart/remove/' . $product->id);
        $response->assertRedirect();

        $cart = session('cart');
        $this->assertFalse(isset($cart[$product->id]));
    }

    /**
     * Test that the cart can be cleared.
     */
    public function test_cart_can_be_cleared(): void
    {
        $category = \App\Models\Category::create(['name' => 'Cat 1', 'slug' => 'cat-1']);
        $product = \App\Models\Product::create([
            'category_id' => $category->id,
            'title_id' => 'Produk A',
            'title_en' => 'Product A',
            'description_id' => 'Desc A',
            'description_en' => 'Desc A',
            'price' => 10000,
            'stock' => 10,
            'images' => ['assets/products/product-1.jpg'],
            'seller_name' => 'Seller A',
            'address' => 'Addr A',
            'is_recommended' => false,
        ]);

        session()->put('cart', [
            $product->id => [
                'product_id' => $product->id,
                'quantity' => 2
            ]
        ]);

        $user = \App\Models\User::factory()->create();
        $response = $this->actingAs($user)->delete('/cart/clear');
        $response->assertRedirect();

        $this->assertFalse(session()->has('cart'));
    }

    /**
     * Test that cart subtotal is calculated correctly based on product database price.
     */
    public function test_subtotal_is_calculated_correctly_from_database(): void
    {
        $category = \App\Models\Category::create(['name' => 'Cat 1', 'slug' => 'cat-1']);
        $productA = \App\Models\Product::create([
            'category_id' => $category->id,
            'title_id' => 'Produk A',
            'title_en' => 'Product A',
            'description_id' => 'Desc A',
            'description_en' => 'Desc A',
            'price' => 150000,
            'stock' => 10,
            'images' => ['assets/products/product-1.jpg'],
            'seller_name' => 'Seller A',
            'address' => 'Addr A',
            'is_recommended' => false,
        ]);
        $productB = \App\Models\Product::create([
            'category_id' => $category->id,
            'title_id' => 'Produk B',
            'title_en' => 'Product B',
            'description_id' => 'Desc B',
            'description_en' => 'Desc B',
            'price' => 50000,
            'stock' => 10,
            'images' => ['assets/products/product-2.jpg'],
            'seller_name' => 'Seller B',
            'address' => 'Addr B',
            'is_recommended' => false,
        ]);

        session()->put('cart', [
            $productA->id => [
                'product_id' => $productA->id,
                'quantity' => 2 // subtotal A = 300,000
            ],
            $productB->id => [
                'product_id' => $productB->id,
                'quantity' => 3 // subtotal B = 150,000
            ]
        ]);

        $response = $this->get('/cart');
        $response->assertStatus(200);
        $response->assertSee('Rp 450.000'); // total = 450,000
    }

    /**
     * Test that AJAX cart updates return proper JSON and correct calculations.
     */
    public function test_cart_quantity_ajax_update_success_and_validations(): void
    {
        $category = \App\Models\Category::create(['name' => 'Cat 1', 'slug' => 'cat-1']);
        $product = \App\Models\Product::create([
            'category_id' => $category->id,
            'title_id' => 'Produk A',
            'title_en' => 'Product A',
            'description_id' => 'Desc A',
            'description_en' => 'Desc A',
            'price' => 100000,
            'stock' => 5,
            'images' => ['assets/products/product-1.jpg'],
            'seller_name' => 'Seller A',
            'address' => 'Addr A',
            'is_recommended' => false,
        ]);

        // Place item in cart
        session()->put('cart', [
            $product->id => [
                'product_id' => $product->id,
                'quantity' => 1
            ]
        ]);

        $user = \App\Models\User::factory()->create();
        // Send AJAX PATCH request to update quantity to 3
        $response = $this->actingAs($user)->patch('/cart/update/' . $product->id, [
            'quantity' => 3
        ], [
            'Accept' => 'application/json'
        ]);

        // Assert response status 200 and exact JSON structure
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'product_id',
            'quantity',
            'item_subtotal',
            'cart_total',
            'cart_count',
            'stock'
        ]);

        // Assert exact JSON contents
        $response->assertJson([
            'success' => true,
            'product_id' => $product->id,
            'quantity' => 3,
            'item_subtotal' => 300000,
            'cart_total' => 300000,
            'cart_count' => 3,
            'stock' => 5
        ]);

        // Assert session quantity updated
        $cart = session('cart');
        $this->assertEquals(3, $cart[$product->id]['quantity']);

        // Now test quantity exceeding stock (attempt to update to 10, stock is 5)
        $responseExceed = $this->actingAs($user)->patch('/cart/update/' . $product->id, [
            'quantity' => 10
        ], [
            'Accept' => 'application/json'
        ]);

        $responseExceed->assertStatus(200);
        $responseExceed->assertJson([
            'success' => false, // returns false indicating warning/stock cap occurred
            'product_id' => $product->id,
            'quantity' => 5, // capped to stock
            'item_subtotal' => 500000,
            'cart_total' => 500000,
            'cart_count' => 5,
            'stock' => 5
        ]);

        // Assert session quantity capped to 5
        $cartExceed = session('cart');
        $this->assertEquals(5, $cartExceed[$product->id]['quantity']);
    }

    /**
     * Test that AJAX product add to cart returns proper JSON and correct validation caps/errors.
     */
    public function test_cart_ajax_add_success_and_validations(): void
    {
        $category = \App\Models\Category::create(['name' => 'Cat 1', 'slug' => 'cat-1']);
        $product = \App\Models\Product::create([
            'category_id' => $category->id,
            'title_id' => 'Produk A',
            'title_en' => 'Product A',
            'description_id' => 'Desc A',
            'description_en' => 'Desc A',
            'price' => 100000,
            'stock' => 5,
            'images' => ['assets/products/product-1.jpg'],
            'seller_name' => 'Seller A',
            'address' => 'Addr A',
            'is_recommended' => false,
        ]);

        $user = \App\Models\User::factory()->create();
        // 1. Successful POST add with JSON Accept
        $response = $this->actingAs($user)->post('/cart/add/' . $product->id, [
            'quantity' => 2
        ], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'product_id',
            'product_quantity',
            'cart_count',
            'stock'
        ]);

        $response->assertJson([
            'success' => true,
            'product_id' => $product->id,
            'product_quantity' => 2,
            'cart_count' => 2,
            'stock' => 5
        ]);

        $cart = session('cart');
        $this->assertEquals(2, $cart[$product->id]['quantity']);

        // 2. Capped quantity test (attempt to add 5 more, making it 7 which exceeds stock of 5)
        $responseExceed = $this->actingAs($user)->post('/cart/add/' . $product->id, [
            'quantity' => 5
        ], [
            'Accept' => 'application/json'
        ]);

        $responseExceed->assertStatus(200);
        $responseExceed->assertJson([
            'success' => false, // capped warning
            'product_id' => $product->id,
            'product_quantity' => 5, // capped to stock
            'cart_count' => 5,
            'stock' => 5
        ]);

        $cartExceed = session('cart');
        $this->assertEquals(5, $cartExceed[$product->id]['quantity']);

        // 3. Out of stock test (stock is 0)
        $outOfStockProduct = \App\Models\Product::create([
            'category_id' => $category->id,
            'title_id' => 'Produk Habis',
            'title_en' => 'Out of stock Product',
            'description_id' => 'Desc',
            'description_en' => 'Desc',
            'price' => 50000,
            'stock' => 0,
            'images' => ['assets/products/product-2.jpg'],
            'seller_name' => 'Seller B',
            'address' => 'Addr B',
            'is_recommended' => false,
        ]);

        $responseOOS = $this->actingAs($user)->post('/cart/add/' . $outOfStockProduct->id, [
            'quantity' => 1
        ], [
            'Accept' => 'application/json'
        ]);

        $responseOOS->assertStatus(400); // 400 Bad Request error
        $responseOOS->assertJson([
            'success' => false,
            'message' => 'Stok tidak cukup.',
            'product_id' => $outOfStockProduct->id,
            'product_quantity' => 0,
            'cart_count' => 5, // still matches the capped count of previous test
            'stock' => 0
        ]);
    }
}
