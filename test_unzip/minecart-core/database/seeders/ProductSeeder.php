<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::query()->delete();

        $categories = Category::all()->pluck('id', 'slug')->toArray();
        $categoryIdMap = Category::all()->pluck('id', 'name_id')->toArray();
        $validCatIds = Category::pluck('id')->toArray();

        $apiDataPath = database_path('data/products.json');
        if (!file_exists($apiDataPath)) {
            $this->command->error("products.json not found!");
            return;
        }

        $apiData = json_decode(file_get_contents($apiDataPath), true);

        foreach ($apiData as $apiItem) {
            // Find category by ID or try mapping it
            $catId = $apiItem['categoryId'] ?? null;
            if (!$catId || !in_array($catId, $validCatIds)) {
                $catId = $validCatIds[array_rand($validCatIds)] ?? 1;
            }

            $images = $apiItem['images'] ?? [];
            if (empty($images)) {
                $images = ['assets/products/product-1.jpg', 'assets/products/product-1.jpg'];
            }

            $addressParts = explode(',', $apiItem['address'] ?? 'Jakarta');
            $sellerName = trim($addressParts[0] ?? 'Toko Online');
            if (strlen($sellerName) > 30) {
                $sellerName = substr($sellerName, 0, 30);
            }

            $seller = User::firstOrCreate(
                ['email' => strtolower(str_replace(' ', '', $sellerName)) . '@seller.minecart.test'],
                [
                    'name' => $sellerName,
                    'password' => Hash::make('password'),
                    'phone' => '0800000000',
                    'address' => $apiItem['address'] ?? 'Alamat Toko',
                    'city' => 'Kota',
                    'postal_code' => '00000',
                    'dob' => '1990-01-01',
                    'gender' => 'male',
                    'is_seller' => true,
                    'store_name' => $sellerName,
                ]
            );

            Product::create([
                'user_id' => $seller->id,
                'category_id' => $catId,
                'title_id' => $apiItem['titleId'] ?? 'Produk Tanpa Nama',
                'title_en' => $apiItem['titleEn'] ?? 'Unnamed Product',
                'description_id' => $apiItem['descriptionId'] ?? '-',
                'description_en' => $apiItem['descriptionEn'] ?? '-',
                'price' => $apiItem['price'] ?? 0,
                'stock' => $apiItem['stock'] ?? 10,
                'images' => $images,
                'address' => $apiItem['address'] ?? 'Toko Online',
                'is_recommended' => $apiItem['isRecommended'] ?? false,
            ]);
        }
    }
}
