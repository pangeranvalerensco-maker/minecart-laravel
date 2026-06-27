<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SellerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_store(): void
    {
        $user = User::factory()->create(['is_seller' => false]);
        
        $response = $this->actingAs($user)->post('/store/create', [
            'store_name' => 'Toko Varel',
        ]);
        
        $response->assertRedirect(route('seller.products.index'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'is_seller' => true,
            'store_name' => 'Toko Varel'
        ]);
    }

    public function test_seller_can_view_products(): void
    {
        $seller = User::factory()->create(['is_seller' => true]);
        
        $response = $this->actingAs($seller)->get(route('seller.products.index'));
        $response->assertStatus(200);
    }

    public function test_non_seller_cannot_view_products(): void
    {
        $user = User::factory()->create(['is_seller' => false]);
        
        $response = $this->actingAs($user)->get(route('seller.products.index'));
        $response->assertRedirect('/');
    }

    public function test_seller_can_create_product(): void
    {
        Storage::fake('public');
        $seller = User::factory()->create(['is_seller' => true, 'city' => 'Jakarta']);
        $category = Category::create(['name' => 'Tech', 'slug' => 'tech']);

        $response = $this->actingAs($seller)->post(route('seller.products.store'), [
            'title_id' => 'Laptop',
            'title_en' => 'Laptop',
            'description_id' => 'Deskripsi Laptop',
            'description_en' => 'Laptop Description',
            'price' => 10000000,
            'stock' => 5,
            'category_id' => $category->id,
            'image' => UploadedFile::fake()->create('product.jpg', 100, 'image/jpeg'),
        ]);

        $response->assertRedirect(route('seller.products.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('products', [
            'title_id' => 'Laptop',
            'user_id' => $seller->id,
            'address' => 'Jakarta'
        ]);
    }

    public function test_seller_can_edit_own_product(): void
    {
        $seller = User::factory()->create(['is_seller' => true]);
        $product = Product::create([
            'user_id' => $seller->id,
            'title_id' => 'Original',
            'title_en' => 'Original EN',
            'description_id' => 'Desc',
            'description_en' => 'Desc EN',
            'price' => 50000,
            'stock' => 10,
            'images' => [],
            'address' => 'Jakarta',
            'is_recommended' => false,
        ]);

        $response = $this->actingAs($seller)->patch(route('seller.products.update', $product->id), [
            'title_id' => 'Updated',
            'title_en' => 'Updated EN',
            'description_id' => 'Desc',
            'description_en' => 'Desc EN',
            'price' => 60000,
            'stock' => 15,
        ]);

        $response->assertRedirect(route('seller.products.index'));
        
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'title_id' => 'Updated',
            'price' => 60000,
            'stock' => 15,
        ]);
    }

    public function test_seller_cannot_edit_other_product(): void
    {
        $seller = User::factory()->create(['is_seller' => true]);
        $otherSeller = User::factory()->create(['is_seller' => true]);
        
        $product = Product::create([
            'user_id' => $otherSeller->id,
            'title_id' => 'Original',
            'title_en' => 'Original EN',
            'description_id' => 'Desc',
            'description_en' => 'Desc EN',
            'price' => 50000,
            'stock' => 10,
            'images' => [],
            'address' => 'Jakarta',
            'is_recommended' => false,
        ]);

        $response = $this->actingAs($seller)->patch(route('seller.products.update', $product->id), [
            'title_id' => 'Updated',
            'title_en' => 'Updated EN',
            'description_id' => 'Desc',
            'description_en' => 'Desc EN',
            'price' => 60000,
            'stock' => 15,
        ]);

        $response->assertStatus(403);
    }
}
