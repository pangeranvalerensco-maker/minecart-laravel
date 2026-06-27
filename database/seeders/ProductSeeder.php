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

        $products = [
            [
                'category_slug' => 'apparel',
                'title_id' => 'Jaket Denim Klasik',
                'title_en' => 'Classic Denim Jacket',
                'description_id' => 'Jaket denim timeless dengan potongan reguler. Terbuat dari bahan denim tebal yang nyaman dan tahan lama.',
                'description_en' => 'A timeless denim jacket with a regular fit cut. Made from thick, comfortable, and durable denim material.',
                'price' => 525000,
                'stock' => 35,
                'images' => ['assets/products/product-1.jpg'],
                'seller_name' => 'Denim Co',
                'address' => 'Jl. Cibaduyut Raya No. 140, Bandung, Jawa Barat',
                'is_recommended' => true,
            ],
            [
                'category_slug' => 'gaming-accessories',
                'title_id' => 'Keyboard Mekanikal Gaming',
                'title_en' => 'Gaming Mechanical Keyboard',
                'description_id' => 'Keyboard mekanikal dengan switch biru dan lampu latar RGB yang bisa dikustomisasi. Rasakan pengalaman mengetik yang responsif.',
                'description_en' => 'Mechanical keyboard with blue switches and customizable RGB backlighting. Experience a responsive typing feel.',
                'price' => 899000,
                'stock' => 20,
                'images' => ['assets/products/product-2.jpg'],
                'seller_name' => 'TechGear',
                'address' => 'Harco Mangga Dua, Lantai 3, Blok B No. 5, Jakarta Pusat, DKI Jakarta',
                'is_recommended' => true,
            ],
            [
                'category_slug' => 'merchandise',
                'title_id' => 'Tas Ransel Harian',
                'title_en' => 'Daily Backpack',
                'description_id' => 'Tas ransel ringan dengan banyak kompartemen, termasuk slot laptop 14 inci. Cocok untuk sekolah atau bekerja.',
                'description_en' => 'A lightweight backpack with multiple compartments, including a 14-inch laptop slot. Perfect for school or work.',
                'price' => 350000,
                'stock' => 50,
                'images' => ['assets/products/product-3.jpg'],
                'seller_name' => 'BagLand',
                'address' => 'Gudang Produksi, Jl. Tajur No. 21, Bogor, Jawa Barat',
                'is_recommended' => true,
            ],
            [
                'category_slug' => 'books-collectibles',
                'title_id' => 'Buku Resep Masakan Nusantara',
                'title_en' => 'Archipelago Cuisine Recipe Book',
                'description_id' => 'Kumpulan 100 resep masakan otentik dari berbagai daerah di Indonesia. Dilengkapi dengan gambar full-color.',
                'description_en' => 'A collection of 100 authentic recipes from various regions in Indonesia. Complemented with full-color pictures.',
                'price' => 225000,
                'stock' => 80,
                'images' => ['assets/products/product-4.jpg'],
                'seller_name' => 'Pustaka Nusantara',
                'address' => 'Toko Buku Gramedia, Jl. Margonda Raya No. 42, Depok, Jawa Barat',
                'is_recommended' => false,
            ],
            [
                'category_slug' => 'gaming-accessories',
                'title_id' => 'Mouse Gaming RGB',
                'title_en' => 'RGB Gaming Mouse',
                'description_id' => 'Mouse gaming dengan sensor sensitivitas tinggi, pencahayaan RGB dinamis, dan tombol makro yang dapat diprogram.',
                'description_en' => 'Gaming mouse with a high-sensitivity sensor, dynamic RGB lighting, and programmable macro buttons.',
                'price' => 350000,
                'stock' => 45,
                'images' => ['assets/products/product-5.jpg'],
                'seller_name' => 'MineGear',
                'address' => 'Ruko Cyber Mall No. 12, Bandung, Jawa Barat',
                'is_recommended' => true,
            ],
            [
                'category_slug' => 'merchandise',
                'title_id' => 'Matras Yoga Anti-Selip',
                'title_en' => 'Anti-Slip Yoga Mat',
                'description_id' => 'Matras yoga tebal 6mm yang empuk dan tidak licin, memberikan stabilitas dan kenyamanan saat berlatih.',
                'description_en' => 'A thick 6mm yoga mat that is soft and non-slip, providing stability and comfort during practice.',
                'price' => 275000,
                'stock' => 60,
                'images' => ['assets/products/product-6.jpg'],
                'seller_name' => 'FitLife',
                'address' => 'Pusat Grosir Olahraga, Jl. Cihampelas No. 98, Bandung, Jawa Barat',
                'is_recommended' => false,
            ],
            [
                'category_slug' => 'electronics',
                'title_id' => 'Mesin Kopi Otomatis',
                'title_en' => 'Automatic Coffee Machine',
                'description_id' => 'Mulai hari Anda dengan kopi segar. Mesin kopi ini bisa membuat espresso dan lungo dengan satu sentuhan.',
                'description_en' => 'Start your day with fresh coffee. This coffee machine can make espresso and lungo with a single touch.',
                'price' => 750000,
                'stock' => 25,
                'images' => ['assets/products/product-7.jpg'],
                'seller_name' => 'KopiTech',
                'address' => 'Toko Peralatan Kopi, Jl. Senopati No. 64, Jakarta Selatan, DKI Jakarta',
                'is_recommended' => true,
            ],
            [
                'category_slug' => 'apparel',
                'title_id' => 'Celana Chino Slim-Fit',
                'title_en' => 'Slim-Fit Chino Pants',
                'description_id' => 'Celana chino dengan potongan slim-fit modern yang terbuat dari bahan katun twill yang nyaman.',
                'description_en' => 'Modern slim-fit chino pants made from comfortable cotton twill material.',
                'price' => 320000,
                'stock' => 75,
                'images' => ['assets/products/product-8.jpg'],
                'seller_name' => 'ChinoCo',
                'address' => 'Factory Outlet, Jl. R.E. Martadinata No. 55, Bandung, Jawa Barat',
                'is_recommended' => false,
            ],
            [
                'category_slug' => 'desk-setup',
                'title_id' => 'Mouse Nirkabel Ergonomis',
                'title_en' => 'Ergonomic Wireless Mouse',
                'description_id' => 'Mouse nirkabel dengan desain ergonomis untuk kenyamanan tangan. Dilengkapi dengan koneksi 2.4GHz yang stabil.',
                'description_en' => 'An ergonomic wireless mouse designed for hand comfort. Equipped with a stable 2.4GHz connection.',
                'price' => 250000,
                'stock' => 110,
                'images' => ['assets/products/product-9.jpg'],
                'seller_name' => 'TechMouse',
                'address' => 'Mal Ambassador, Lantai 2, Jl. Prof. DR. Satrio, Jakarta Selatan, DKI Jakarta',
                'is_recommended' => true,
            ],
            [
                'category_slug' => 'books-collectibles',
                'title_id' => 'Novel Grafis Fantasi',
                'title_en' => 'Fantasy Graphic Novel',
                'description_id' => 'Ikuti petualangan epik di dunia sihir melalui ilustrasi yang memukau dalam novel grafis ini.',
                'description_en' => 'Follow an epic adventure in a world of magic through stunning illustrations in this graphic novel.',
                'price' => 120000,
                'stock' => 90,
                'images' => ['assets/products/product-10.jpg'],
                'seller_name' => 'ComicWorld',
                'address' => 'Toko Buku Togamas, Jl. Affandi No. 5, Yogyakarta, DIY',
                'is_recommended' => true,
            ],
            [
                'category_slug' => 'merchandise',
                'title_id' => 'Jam Tangan Kulit Klasik',
                'title_en' => 'Classic Leather Watch',
                'description_id' => 'Jam tangan analog dengan tali kulit asli dan bingkai stainless steel. Desain elegan yang cocok untuk segala acara.',
                'description_en' => 'An analog watch with a genuine leather strap and stainless steel frame. An elegant design suitable for all occasions.',
                'price' => 650000,
                'stock' => 40,
                'images' => ['assets/products/product-11.jpg'],
                'seller_name' => 'ClassicTime',
                'address' => 'Plaza Senayan, Lantai 1, Jl. Asia Afrika, Jakarta Pusat, DKI Jakarta',
                'is_recommended' => false,
            ],
            [
                'category_slug' => 'merchandise',
                'title_id' => 'Tabir Surya SPF 50+',
                'title_en' => 'Sunscreen SPF 50+',
                'description_id' => 'Lindungi kulit Anda dari sinar UV dengan tabir surya ringan yang tidak lengket dan cepat meresap.',
                'description_en' => 'Protect your skin from UV rays with this lightweight, non-sticky, and fast-absorbing sunscreen.',
                'price' => 175000,
                'stock' => 85,
                'images' => ['assets/products/product-12.jpg'],
                'seller_name' => 'SunShield',
                'address' => 'Watsons, Tunjungan Plaza 3, Surabaya, Jawa Timur',
                'is_recommended' => true,
            ],
            [
                'category_slug' => 'merchandise',
                'title_id' => 'Botol Minum Olahraga 1L',
                'title_en' => '1L Sports Water Bottle',
                'description_id' => 'Botol minum bebas BPA dengan penanda waktu untuk memastikan hidrasi Anda tercukupi sepanjang hari.',
                'description_en' => 'BPA-free water bottle with time markers to ensure you stay hydrated throughout the day.',
                'price' => 150000,
                'stock' => 120,
                'images' => ['assets/products/product-13.jpg'],
                'seller_name' => 'HydrateCo',
                'address' => 'Toko Olahraga Jaya, Jl. Gajah Mada No. 12, Semarang, Jawa Tengah',
                'is_recommended' => false,
            ],
            [
                'category_slug' => 'electronics',
                'title_id' => 'Blender Jus Portabel',
                'title_en' => 'Portable Juice Blender',
                'description_id' => 'Buat jus segar di mana saja dengan blender portabel yang bisa diisi ulang menggunakan USB.',
                'description_en' => 'Make fresh juice anywhere with this portable blender that can be recharged via USB.',
                'price' => 450000,
                'stock' => 30,
                'images' => ['assets/products/product-14.jpg'],
                'seller_name' => 'JuiceMaker',
                'address' => 'ACE Hardware, Jl. Sunset Road, Kuta, Bali',
                'is_recommended' => true,
            ],
            [
                'category_slug' => 'apparel',
                'title_id' => 'Hoodie Polos Fleece',
                'title_en' => 'Plain Fleece Hoodie',
                'description_id' => 'Hoodie basic yang terbuat dari bahan fleece tebal yang lembut, memberikan kehangatan maksimal.',
                'description_en' => 'A basic hoodie made from soft, thick fleece material, providing maximum warmth.',
                'price' => 380000,
                'stock' => 65,
                'images' => ['assets/products/product-15.jpg'],
                'seller_name' => 'FleeceCo',
                'address' => 'Jl. Trunojoyo No. 4, Bandung, Jawa Barat',
                'is_recommended' => true,
            ],
            [
                'category_slug' => 'electronics',
                'title_id' => 'Speaker Bluetooth Portabel',
                'title_en' => 'Portable Bluetooth Speaker',
                'description_id' => 'Speaker ringkas dengan kualitas suara bass yang kuat dan baterai yang tahan lama. Tahan percikan air.',
                'description_en' => 'A compact speaker with strong bass sound quality and a long-lasting battery. Splash-proof.',
                'price' => 550000,
                'stock' => 55,
                'images' => ['assets/products/product-16.jpg'],
                'seller_name' => 'SoundLink',
                'address' => 'Toko Elektronik Sinar Jaya, Jl. Ahmad Yani No. 150, Medan, Sumatera Utara',
                'is_recommended' => false,
            ],
        ];

        $apiDataPath = database_path('data/products.json');
        $apiImagesMap = [];
        if (file_exists($apiDataPath)) {
            $apiData = json_decode(file_get_contents($apiDataPath), true);
            foreach ($apiData as $apiItem) {
                $apiImagesMap[$apiItem['titleId']] = $apiItem['images'] ?? [];
            }
        }

        foreach ($products as $item) {
            $catSlug = $item['category_slug'];
            unset($item['category_slug']);
            
            $item['category_id'] = $categories[$catSlug] ?? null;

            // Use real API images if available
            if (isset($apiImagesMap[$item['title_id']]) && count($apiImagesMap[$item['title_id']]) > 0) {
                $item['images'] = $apiImagesMap[$item['title_id']];
            } else {
                if (isset($item['images']) && count($item['images']) > 0) {
                    $img = $item['images'][0];
                    $item['images'] = [$img, $img, $img, $img];
                }
            }

            $sellerName = $item['seller_name'];
            unset($item['seller_name']);

            $seller = User::firstOrCreate(
                ['email' => strtolower(str_replace(' ', '', $sellerName)) . '@seller.minecart.test'],
                [
                    'name' => $sellerName,
                    'password' => Hash::make('password'),
                    'phone' => '0800000000',
                    'address' => $item['address'],
                    'city' => 'Bandung',
                    'postal_code' => '40000',
                    'dob' => '1990-01-01',
                    'gender' => 'male',
                    'is_seller' => true,
                    'store_name' => $sellerName,
                ]
            );

            $item['user_id'] = $seller->id;

            Product::create($item);
        }
    }
}
