<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BugFixTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_checkout()
    {
        config(['session.driver' => 'database']);
        $this->app['session']->setDefaultDriver('database');
        DB::table('categories')->insert(['id' => 1, 'name' => 'Test', 'slug' => 'test']);
        // Give guest a cart
        $product = Product::create([
            'title_id' => 'Produk A',
            'title_en' => 'Product A',
            'description_id' => 'Desc A',
            'description_en' => 'Desc A',
            'price' => 100,
            'stock' => 10,
            'category_id' => 1,
            'images' => '[]',
            'address' => 'Jakarta'
        ]);
        session()->put('cart', [
            $product->id => ['quantity' => 2]
        ]);

        // Attempt checkout
        $response = $this->get('/checkout');

        // Should be redirected to login
        $response->assertRedirect('/login');
        $response->assertSessionHas('warning');
    }

    public function test_cart_is_intact_after_login()
    {
        config(['session.driver' => 'database']);
        $this->app['session']->setDefaultDriver('database');
        DB::table('categories')->insert(['id' => 1, 'name' => 'Test', 'slug' => 'test']);
        // 1. Create product and user
        $product = Product::create([
            'title_id' => 'Produk A',
            'title_en' => 'Product A',
            'description_id' => 'Desc A',
            'description_en' => 'Desc A',
            'price' => 100,
            'stock' => 10,
            'category_id' => 1,
            'images' => '[]',
            'address' => 'Jakarta'
        ]);
        $product2 = Product::create([
            'title_id' => 'Produk B',
            'title_en' => 'Product B',
            'description_id' => 'Desc B',
            'description_en' => 'Desc B',
            'price' => 200,
            'stock' => 5,
            'category_id' => 1,
            'images' => '[]',
            'address' => 'Jakarta'
        ]);
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123')
        ]);

        // 2. Set cart as guest
        $cartData = [
            $product->id => ['quantity' => 2],
            $product2->id => ['quantity' => 1]
        ];
        
        $response = $this->withSession(['cart' => $cartData])->get('/');
        $response->assertSessionHas('cart', $cartData);

        // 3. Login
        $loginResponse = $this->withSession(['cart' => $cartData])->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        // 4. Assert login success
        $loginResponse->assertRedirect('/');
        $this->assertAuthenticatedAs($user);

        // 5. Assert cart is STILL INTACT
        $loginResponse->assertSessionHas('cart');
        $this->assertEquals($cartData, session('cart'));
    }
}
