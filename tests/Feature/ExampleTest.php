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
}
