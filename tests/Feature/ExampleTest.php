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
        $product = \App\Models\Product::create([
            'category_id' => $category->id,
            'title_id' => 'Detail Product A',
            'title_en' => 'Detail Product A',
            'description_id' => 'Deskripsi detail produk A',
            'description_en' => 'English details A',
            'price' => 150000,
            'stock' => 10,
            'images' => ['assets/products/product-1.jpg'],
            'seller_name' => 'Toko Varel',
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
}
