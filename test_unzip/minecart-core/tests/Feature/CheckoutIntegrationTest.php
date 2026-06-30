<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutIntegrationTest extends TestCase
{
    use RefreshDatabase;

    private function createProduct(): Product
    {
        $category = \App\Models\Category::firstOrCreate(
            ['slug' => 'test-cat'],
            ['name' => 'Test Category']
        );

        return Product::create([
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
        ]);
    }

    public function test_guest_is_redirected_to_login_from_checkout()
    {
        $product = $this->createProduct();

        $this->withSession([
            'cart' => [
                $product->id => [
                    'quantity' => 1,
                ]
            ]
        ]);

        $response = $this->get('/checkout');

        $response->assertRedirect('/login');
        $response->assertSessionHas('warning');
    }

    public function test_user_is_redirected_back_to_checkout_after_login()
    {
        $product = $this->createProduct();

        $this->withSession([
            'cart' => [
                $product->id => [
                    'quantity' => 1,
                ]
            ]
        ]);

        // Attempting to access checkout sets the intended URL
        $this->get('/checkout');

        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        // Login should redirect to intended URL (checkout)
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/checkout');

        // Cart should still exist
        $this->assertTrue(session()->has('cart'));
    }

    public function test_checkout_saves_user_id()
    {
        $user = User::factory()->create();
        $product = $this->createProduct();

        $this->actingAs($user)->withSession([
            'cart' => [
                $product->id => [
                    'quantity' => 1,
                ]
            ]
        ]);

        $response = $this->post('/checkout', [
            'fullname' => 'Test Name',
            'phone' => '0812345',
            'address' => 'Test Address',
            'city' => 'Jakarta',
            'postal_code' => '12345',
            'payment_method' => 'bca_va',
        ]);

        $response->assertRedirect('/checkout/success');

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'fullname' => 'Test Name',
            'payment_method' => 'bca_va',
        ]);
    }
}
