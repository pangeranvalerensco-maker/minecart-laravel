# Development Log: MineCart Migration

Jurnal ini mencatat setiap langkah, keputusan desain, dan progres implementasi selama proses migrasi e-commerce **MineCart** dari web statis ke monolithic Laravel 12.

---

## [2026-06-19] Analisis Awal & Pembuatan Dokumen Perencanaan

### Pekerjaan yang Dilakukan:
1. **Analisis Struktur Kode Legacy (`minecart-legacy`)**:
   - Memeriksa file utama `index.html` dan sepuluh file HTML pendukung di direktori `html/`.
   - Menganalisis file CSS `css/style.css` (3000+ baris) yang berisi deklarasi variabel untuk mode Overworld (terang) dan Cave (gelap) serta font Press Start 2P/Inter.
   - Menganalisis file JS `js/script.js` (2700+ baris) yang berisi konfigurasi API eksternal, kamus terjemahan, simulator ongkir, manajemen keranjang via `localStorage`, dan auth mock.
2. **Analisis Struktur Laravel (`minecart-laravel`)**:
   - Memverifikasi kesiapan dasar Laravel 12 dengan PHP 8.2 dan PostgreSQL.
3. **Dokumentasi Rencana Migrasi**:
   - Membuat file `PROJECT_CONTEXT.md` sebagai rangkuman arah migrasi dan spesifikasi teknologi final.
   - Membuat file `FEATURE_SCOPE.md` untuk memetakan halaman statis lama ke rute controller Laravel serta transisi fitur.
   - Membuat file `DATABASE_SCHEMA.md` untuk merancang tabel `categories`, `products`, `orders`, dan `order_items` beserta relasinya di PostgreSQL.
   - Membuat file `IMPLEMENTATION_PLAN.md` yang memecah proses pengerjaan menjadi 9 tahap kecil yang logis.
   - Menginisialisasi file `DEVELOPMENT_LOG.md` ini untuk mencatat jalannya proyek.

### Hasil Analisis Penting:
- **Sumber Data**: Data produk lama diambil dari `https://my-api-theta-three.vercel.app/pangeran/api`. Untuk migrasi, data ini akan diambil oleh seeder Laravel untuk dimasukkan ke database PostgreSQL lokal sehingga operasi read/write stok berjalan server-side.
- **Logika Ongkir**: Di dalam `script.js` legacy, tarif dihitung berdasarkan data statis `shippingCostsData` yang mendefinisikan biaya intra-provinsi, luar-provinsi, dan basis tarif untuk kota-kota besar di Indonesia (seperti Bandung, Jakarta, Surabaya, dll.). Logika ini harus diimplementasikan ulang di PHP agar kalkulasi ongkir aman dari manipulasi klien.
- **Bahasa & Tema**: Preferensi bahasa disimpan di `localStorage` (`userLanguage`) dan tema disimpan di `theme` (`light`/`dark`). Kita akan memindahkan preferensi bahasa ke middleware session/cookie Laravel, dan preferensi tema ke Cookie agar server dapat langsung memberikan class CSS yang tepat ke tag `<body>` saat loading awal halaman.

### Hambatan & Rencana Solusi:
- *Hambatan*: Tidak diperbolehkan memodifikasi berkas `.env` asli secara langsung di luar konfigurasi port database yang sudah disiapkan workspace.
- *Solusi*: Pastikan konfigurasi database di database Laravel menggunakan konfigurasi default yang kompatibel atau memanfaatkannya dengan aman sesuai lingkungan yang diberikan.

---

## [2026-06-19] Sprint 1: Migrasi Aset, Layout Blade, dan Halaman Beranda Statis

### Pekerjaan yang Dilakukan:
1. **Penyalinan Aset dan CSS**:
   - Menyalin semua aset dari [minecart-legacy/assets](file:///e:/E-Commerce%20Projects/minecart-legacy/assets) ke [minecart-laravel/public/assets](file:///e:/E-Commerce%20Projects/minecart-laravel/public/assets).
   - Menyalin berkas [style.css](file:///e:/E-Commerce%20Projects/minecart-legacy/css/style.css) ke [style.css](file:///e:/E-Commerce%20Projects/minecart-laravel/public/css/style.css).
2. **Pembuatan Layout Utama & Partials**:
   - Membuat master layout [app.blade.php](file:///e:/E-Commerce%20Projects/minecart-laravel/resources/views/layouts/app.blade.php) yang memuat CSS secara statis, mendefinisikan layout HTML, mengintegrasikan script anti-flicker tema, dan memuat aset JavaScript.
   - Membuat partial [header.blade.php](file:///e:/E-Commerce%20Projects/minecart-laravel/resources/views/partials/header.blade.php) yang memuat navigasi utama, logo, dropdown bahasa, input pencarian, dan tombol tema.
   - Membuat partial [footer.blade.php](file:///e:/E-Commerce%20Projects/minecart-laravel/resources/views/partials/footer.blade.php) berisi teks hak cipta.
3. **Pembuatan Halaman Beranda**:
   - Membuat [HomeController.php](file:///e:/E-Commerce%20Projects/minecart-laravel/app/Http/Controllers/HomeController.php) untuk melayani rute `/` (dengan nama rute `home`).
   - Membuat berkas [home.blade.php](file:///e:/E-Commerce%20Projects/minecart-laravel/resources/views/home.blade.php) berisi hero carousel, popup Customer Service, dan 4 skeleton card produk rekomendasi statis.
4. **Logika JavaScript Antarmuka**:
   - Membuat berkas [ui.js](file:///e:/E-Commerce%20Projects/minecart-laravel/public/js/ui.js) yang memuat logika murni untuk carousel otomatis, toggle hamburger menu, toggle mode gelap/terang, dropdown bahasa (serta sinkronisasi link bahasa mobile), pop-up Customer Service, dan visualisasi notifikasi toast.

### Keputusan Desain & Penyesuaian:
- **Pemuatan Aset**: Seluruh gambar dan logo dalam Blade dimuat menggunakan helper `{{ asset('assets/filename') }}`. Untuk JavaScript, window object `window.minecartAssets` digunakan untuk meneruskan URL absolut dari server ke file JavaScript klien agar penggantian tema ikon aman di URL mana pun.
- **Produk Rekomendasi**: Grid produk rekomendasi diisi dengan 4 skeleton card bertema abu-abu abu yang meload logo MineCart untuk mempertahankan struktur visual dan responsivitas layout lama semirip mungkin.
- **Logika Data**: Seluruh fungsionalitas fetch data, login/register localStorage, akun, keranjang belanja, dan checkout sengaja tidak disertakan di file `ui.js` agar bersih dari state client-side lama dan siap diintegrasikan dengan database/session di sprint berikutnya.

---

## [2026-06-19] Penyesuaian Visual & Responsif Sprint 1

### Pekerjaan yang Dilakukan:
1. **Perbaikan Search Bar**:
   - Menyelaraskan masukan input dan tombol pencarian dengan flexbox `.search-bar button { display: flex; align-items: center; justify-content: center; }`.
   - Mengatur ukuran ikon pencarian secara proporsional (`height: 18px; width: 18px;`) menggunakan aset asli `logo-search.png` agar tidak terpotong.
2. **Kalkulasi Tampilan & Hover Menu Navigasi**:
   - Memperbaiki helper bahasa JavaScript `translateUI` di [ui.js](file:///e:/E-Commerce%20Projects/minecart-laravel/public/js/ui.js) agar mendeteksi atribut `title`. Ini mencegah penulisan ulang konten HTML di navigasi sehingga ikon keranjang belanja dan ikon tombol tema tetap utuh dan tidak berubah menjadi teks deskripsi panjang ("Lihat Keranjang Belanja" / "Ubah Tema").
   - Menambahkan badge statis kuantitas bernilai `0` dengan kelas `.cart-counter.visible` agar langsung muncul di sisi kanan atas ikon keranjang.
   - Menambahkan span teks `.cart-text-mobile` (bernilai "Keranjang Belanja") yang disembunyikan di layar desktop tetapi ditampilkan rapi pada perangkat mobile.
3. **Perapihan Spacing & Responsivitas Layout**:
   - Menambahkan media query `@media (max-width: 1200px) and (min-width: 769px)` untuk memperkecil celah navigasi (`gap: 12px;`) dan margin search bar (`margin: 0 15px;`) demi mencegah menu bertumpuk/turun pada resolusi laptop menengah (1024px).
   - Memverifikasi tampilan responsif pada rentang 1440px (desktop), 1024px (tablet landscape), 768px (tablet portrait/mobile menu active), dan 375px (mobile standar).
4. **Pembersihan Teks CS Popup**:
   - Mengganti teks mock DIVDIK dengan instruksi bantuan resmi: *"Butuh bantuan? Hubungi tim MineCart melalui informasi kontak yang tersedia."*

---

## [2026-06-19] Sprint 2: Database Kategori, Produk, dan Rekomendasi Dinamis

### Pekerjaan yang Dilakukan:
1. **Migrasi Database**:
   - Membuat migrasi `create_categories_table` dengan atribut `id`, `name`, dan `slug` (unik).
   - Membuat migrasi `create_products_table` dengan relasi `category_id` (foreign key nullable), `title_id`, `title_en`, `description_id`, `description_en`, `price` (bigInteger), `stock` (integer), `images` (json), `seller_name` (nullable), `address`, dan `is_recommended` (boolean).
   - Menjalankan migrasi secara bersih ke database PostgreSQL lokal.

2. **Pembuatan Model**:
   - Membuat model `Category` dengan relasi `hasMany` ke `Product`.
   - Membuat model `Product` dengan relasi `belongsTo` ke `Category` serta menerapkan Eloquent casting (`images => array`, `is_recommended => boolean`, `price => integer`, `stock => integer`).

3. **Penyusunan Seeders & Aset Lokal**:
   - Membuat `CategorySeeder` untuk menginisialisasi 6 kategori bisnis secara teratur.
   - Mengunduh dan menempatkan aset produk legacy ke folder `public/assets/products/` sehingga seeder berjalan sepenuhnya lokal tanpa dependensi API eksternal.
   - Membuat `ProductSeeder` yang menanam 16 produk dengan data deterministik dari `api_response.json` (termasuk 10 produk dengan `is_recommended = true`).
   - Menghapus berkas `api_response.json` dari root proyek agar tidak masuk riwayat Git.

4. **Integrasi Controller & Rendering Beranda**:
   - Memperbarui `HomeController@index` untuk mengambil maksimal 8 produk rekomendasi dengan eager loading relasi `category`.
   - Mengubah `home.blade.php` untuk merender data produk secara dinamis menggunakan `@forelse` dengan penanganan empty state (menampilkan informasi database kosong) dan membuang skeleton card statis.
   - Mengatur atribut HTML `data-title-id`, `data-title-en`, `data-description-id`, dan `data-description-en` pada struktur kartu produk untuk mendukung lokalisasi dinamis.

5. **Pembaruan Translasi Klien**:
   - Memodifikasi berkas [ui.js](file:///e:/E-Commerce%20Projects/minecart-laravel/public/js/ui.js) pada fungsi `translateUI` agar mendeteksi kartu produk dinamis dan mengganti teks judul serta deskripsi produk saat tombol bahasa diubah secara real-time.

6. **Penyusunan dan Pengujian Test Suite**:
   - Menambahkan pengujian fitur baru di `tests/Feature/ExampleTest.php` untuk memastikan:
     - Halaman beranda memuat dengan status 200.
     - Produk rekomendasi dirender dengan format harga dan nama yang tepat sesuai database.
     - Produk non-rekomendasi tidak dimuat di bagian rekomendasi.
     - Penanganan empty state berfungsi dengan baik saat tidak ada produk di database.
   - Menjalankan pengujian fungsional dan unit testing via `php artisan test` dengan hasil sukses (`PASS`).

### Hasil Tinker & Pengujian:
- Jumlah Kategori (`Category::count()`): **6**
- Jumlah Produk (`Product::count()`): **16**
- Jumlah Produk Rekomendasi (`Product::where('is_recommended', true)->count()`): **10**
- Status Test Suite: **4 Passed (8 Assertions)**

### Perbaikan Pasca-Audit Sprint 2:
1. **Restrukturisasi Kartu Produk**:
   - Menghapus pembungkus `<a>` yang melingkupi seluruh kartu produk (`.product-card`) demi validitas semantik HTML.
   - Menambahkan tautan terpisah untuk gambar produk (`.product-image-link`) dan judul produk (`.product-title-link`) dengan nilai `#` sementara.
   - Mengatur styling agar tidak ada garis bawah (`text-decoration: none`) pada judul, deskripsi, harga, maupun tombol, serta mencegah warna ungu visited link.
2. **Desain Footer Kartu & Keterbacaan Harga**:
   - Menerapkan `flex-wrap: wrap` dan `gap: 10px` pada footer kartu untuk responsivitas layout flexbox.
   - Mengatur `white-space: nowrap` pada elemen `.price` dan tombol `.buy-btn` untuk menjamin kesatuan teks "Rp [Nominal]" dan teks tombol agar tidak pecah/wrap berantakan di layar kecil.
   - Menerapkan tinggi kartu yang konsisten di semua resolusi grid.
3. **Pembatasan Baris Deskripsi**:
   - Menerapkan `-webkit-line-clamp: 3` beserta property `height: 4.8em` pada deskripsi produk untuk membatasi panjang teks maksimal 3 baris secara rapi dan seragam.
4. **Optimasi Gambar Produk**:
   - Memastikan rasio aspek gambar tetap terjaga dengan `object-fit: cover` pada `.product-image-link img` dan menambahkan efek micro-animation transisi zoom halus saat hover.
5. **Pembaruan Data Seeder**:
   - Mengganti produk "Serum Pencerah Wajah" (merchandise) dengan "Mouse Gaming RGB" (gaming-accessories) agar relevan dengan 6 kategori bisnis MineCart, menggunakan aset lokal `product-5.jpg` yang sesuai.
   - Menambahkan `Product::query()->delete();` di awal seeder untuk memastikan proses seeding bersih, aman, dan tidak menduplikasi data saat dijalankan berulang kali.

---

## [2026-06-19] Sprint 3: Halaman Katalog dan Detail Produk

### Pekerjaan yang Dilakukan:
1. **Pembuatan ProductController**:
   - Menambahkan berkas `ProductController.php` dengan aksi `index()` untuk mengelola pencarian produk, filter berdasarkan kategori slug, dan sorting dinamis (`price_asc/desc`, `name_asc/desc`, `stock_asc/desc`).
   - Menambahkan aksi `show()` untuk menampilkan detail satu produk dan mengambil maksimal 4 produk terkait (`relatedProducts`) dari kategori yang sama.
2. **Penyusunan Rute Baru**:
   - Mendaftarkan rute `/products` (products.index) dan `/products/{product}` (products.show) di `web.php`.
3. **Desain Tampilan Katalog (`products/index.blade.php`)**:
   - Menampilkan daftar semua produk dalam grid.
   - Mengintegrasikan filter kategori menggunakan `<button>` dengan inline redirection agar mempertahankan style legacy MineCart.
   - Menambahkan dropdown sort untuk mengubah urutan produk secara instan.
   - Menyediakan empty state ber-ilustrasi jika hasil pencarian atau filter kosong.
4. **Desain Tampilan Detail (`products/show.blade.php`)**:
   - Menampilkan layout detail produk dengan galeri thumbnail interaktif menggunakan script JS sederhana untuk mengganti gambar utama.
   - Menampilkan informasi lengkap produk (judul, kategori, harga, stok, nama/alamat toko) dan maksimal 4 produk sejenis di section rekomendasi bawah.
5. **Integrasi Navigasi & Tautan**:
   - Mengarahkan pencarian header, tombol "Semua Produk", "Lihat Semua Produk", dan "Lihat Lainnya" ke rute `products.index`.
   - Mengarahkan kartu produk homepage ke rute detail masing-masing (`products.show`).
6. **Lokalisasi Multibahasa Dinamis**:
   - Memodifikasi `ui.js` untuk menambahkan terjemahan detail produk dan memperbarui judul browser tab secara dinamis di seluruh halaman katalog dan detail produk.
7. **Penyusunan Test Suite**:
   - Menambahkan pengujian fitur katalog: verifikasi muatan halaman katalog, fungsionalitas pencarian kata kunci, filter kategori, pengurutan (sorting), tampilan detail, serta pengujian status 404 jika ID produk tidak valid.

### Hasil Pengujian:
- Status Test Suite: **10 Passed (34 Assertions)**
- Rute terdaftar: `/products` dan `/products/{product}`

---

## [2026-06-19] Sprint 4: Keranjang Belanja Berbasis Laravel Session

### Pekerjaan yang Dilakukan:
1. **Pembuatan CartController**:
   - Menambahkan aksi `index()` untuk memetakan produk dari PostgreSQL berdasarkan item keranjang di session, menghitung subtotal per item, subtotal total, serta total kuantitas barang.
   - Menambahkan aksi `add()` untuk menambah produk ke session dengan validasi stok (produk dengan stok 0 ditolak, penambahan di atas stok maksimum secara otomatis dibatasi ke stok maksimum disertai warning).
   - Menambahkan aksi `update()` untuk memperbarui kuantitas (minimal 1 dan maksimal sesuai stok produk).
   - Menambahkan aksi `remove()` untuk menghapus item tertentu dari session keranjang.
   - Menambahkan aksi `clear()` untuk menghapus/mengosongkan seluruh session keranjang belanja.
2. **Rute Keranjang Belanja**:
   - Mendaftarkan rute keranjang: `GET /cart`, `POST /cart/add/{product}`, `PATCH /cart/update/{product}`, `DELETE /cart/remove/{product}`, dan `DELETE /cart/clear`.
3. **Desain Halaman Keranjang (`cart/index.blade.php`)**:
   - Menampilkan layout keranjang belanja `.cart-section` lengkap dengan item list (gambar, nama, harga satuan, quantity controls `+` / `-`, subtotal per item, tombol Hapus).
   - Menambahkan sidebar `.cart-summary` (subtotal total, kuantitas total, dan tombol Beli/Checkout disabled).
   - Menyediakan tombol "Kosongkan Keranjang" di `.cart-header` dan visualisasi empty state jika keranjang kosong.
4. **Integrasi UI & Header Badge**:
   - Mengubah layout `app.blade.php` agar menangkap flash message Session Laravel (`success`, `error`, `warning`) dan menampilkannya sebagai notifikasi toast.
   - Mengintegrasikan total kuantitas seluruh item dari session secara dinamis pada badge `cart-counter` di header navigasi.
   - Mengubah tombol "Tambah ke Keranjang" pada home, katalog, dan detail produk menjadi form POST lengkap dengan `@csrf`, serta menonaktifkan tombol secara visual jika stok produk habis (<= 0).
5. **Pengembangan Test Suite**:
   - Menambahkan 8 feature tests di `ExampleTest.php` untuk memverifikasi fungsionalitas keranjang: akses halaman keranjang, penambahan produk, penolakan produk habis (stok 0), pembaruan kuantitas, pembatasan kuantitas sesuai stok, penghapusan produk, pengosongan keranjang, dan kalkulasi subtotal dari database.

### Hasil Pengujian:
- Status Test Suite: **18 Passed (56 Assertions)**
- Rute terdaftar: 11 rute terdaftar dengan benar.

---

## [2026-06-19] Sprint 4: Perbaikan UX Keranjang Belanja dengan AJAX dan Vanilla JS

### Pekerjaan yang Dilakukan:
1. **Layout Utama**:
   - Menambahkan `<meta name="csrf-token" content="{{ csrf_token() }}">` pada [app.blade.php](file:///e:/E-Commerce%20Projects/minecart-laravel/resources/views/layouts/app.blade.php) untuk otentikasi AJAX request.
2. **Optimasi CartController@update**:
   - Memodifikasi method `update()` di [CartController.php](file:///e:/E-Commerce%20Projects/minecart-laravel/app/Http/Controllers/CartController.php) agar mendeteksi AJAX request (`expectsJson()`).
   - Mengembalikan JSON berisi state keranjang terbaru: `success`, `message`, `product_id`, `quantity`, `item_subtotal`, `cart_total`, `cart_count`, dan `stock`.
   - Menghitung semua harga dan subtotal dari database `Product` demi keamanan data.
   - Membatasi kuantitas minimal 1 dan maksimal sesuai stock produk.
3. **Penyelarasan View Keranjang (`cart/index.blade.php`)**:
   - Mengubah tombol `+` dan `-` menjadi `type="button"` serta menambahkan atribut `data-product-id` dan `data-stock`.
   - Menambahkan ID/selector yang jelas untuk quantity span, item subtotal, total items summary, total price, dan badge keranjang.
   - Menyertakan fallback form dan `<noscript>` block sehingga tombol plus/minus tetap berfungsi secara konvensional (submit form & reload) jika Javascript dinonaktifkan di browser.
   - Memuat file script `js/cart.js` secara eksklusif hanya di halaman keranjang belanja.
4. **Implementasi Script AJAX (`public/js/cart.js`)**:
   - Membuat modular script [cart.js](file:///e:/E-Commerce%20Projects/minecart-laravel/public/js/cart.js) untuk meng-intercept klik tombol `+` dan `-`.
   - Mengirim request PATCH via `fetch()` dengan menyertakan token CSRF.
   - Memperbarui DOM secara asinkron tanpa reload halaman (kuantitas item, subtotal item, total harga keseluruhan, badge keranjang di header, dan dropdown keranjang).
   - Menonaktifkan tombol sementara request sedang dikirim agar mencegah double-click asinkron.
   - Memberikan proteksi batas kuantitas minimum (1) dan maksimum (stok produk) secara client-side dan server-side, serta memicu notifikasi toast via `showToast()`.
5. **Feature Test Tambahan**:
   - Menambahkan `test_cart_quantity_ajax_update_success_and_validations` di [ExampleTest.php](file:///e:/E-Commerce%20Projects/minecart-laravel/tests/Feature/ExampleTest.php) untuk memverifikasi response JSON 200, update session keranjang, dan validasi capping batas stok produk.

### Hasil Pengujian & Pembersihan:
- Status Test Suite: **19 Passed (70 Assertions)**
- Rute terdaftar: 11 rute terdaftar dengan benar.
- Menjalankan `php artisan optimize:clear` untuk membersihkan seluruh cache aplikasi.

---

## [2026-06-19] Sprint 4: AJAX Global untuk Penambahan Produk ke Keranjang

### Pekerjaan yang Dilakukan:
1. **Pembaruan CartController@add**:
   - Memodifikasi method `add()` di [CartController.php](file:///e:/E-Commerce%20Projects/minecart-laravel/app/Http/Controllers/CartController.php) agar mendeteksi AJAX request.
   - Mengembalikan data state asinkron: `success`, `message`, `product_id`, `product_quantity`, `cart_count`, dan `stock`.
   - Mengembalikan HTTP status `400` untuk penambahan produk yang stoknya habis (0).
   - Menghitung kuantitas kumulatif di server-side serta melakukan pembatasan (cap) sesuai batas stok aktual produk di database.
2. **Pembaruan Form View**:
   - Menambahkan class `.js-add-to-cart-form` pada form penambahan produk di:
     - [home.blade.php](file:///e:/E-Commerce%20Projects/minecart-laravel/resources/views/home.blade.php) (rekomendasi produk di homepage)
     - [index.blade.php](file:///e:/E-Commerce%20Projects/minecart-laravel/resources/views/products/index.blade.php) (catalog produk)
     - [show.blade.php](file:///e:/E-Commerce%20Projects/minecart-laravel/resources/views/products/show.blade.php) (detail utama & produk rekomendasi terkait)
   - Mempertahankan tipe tombol `type="submit"` dan token `@csrf` agar fallback konvensional tetap bekerja jika JavaScript dimatikan.
3. **Pemuatan Script Global**:
   - Mendaftarkan file script global [cart-actions.js](file:///e:/E-Commerce%20Projects/minecart-laravel/public/js/cart-actions.js) pada master layout [app.blade.php](file:///e:/E-Commerce%20Projects/minecart-laravel/resources/views/layouts/app.blade.php).
4. **Implementasi `public/js/cart-actions.js`**:
   - Meng-intercept event `submit` dari `.js-add-to-cart-form` dengan `preventDefault()`.
   - Melakukan request POST asinkron via `fetch()`.
   - Menonaktifkan tombol submit selama request berlangsung.
   - Memperbarui badge total item di header (`#cart-counter` & `#cart-preview-title`) secara dinamis.
   - Menampilkan notifikasi `showToast()` bertipe `success`, `warning` (jika kuantitas dibatasi), atau `error` (jika request gagal atau stok habis).
   - Menerapkan micro-interaction: mengubah teks tombol sementara menjadi "Ditambahkan" selama 1 detik setelah penambahan berhasil.
5. **Feature Test Tambahan**:
   - Menambahkan method pengujian `test_cart_ajax_add_success_and_validations` di [ExampleTest.php](file:///e:/E-Commerce%20Projects/minecart-laravel/tests/Feature/ExampleTest.php) untuk memverifikasi response JSON, kalkulasi kuantitas kumulatif, penolakan stok habis dengan kode HTTP 400, dan pembatasan stok maks.

### Hasil Pengujian & Pembersihan:
- Status Test Suite: **20 Passed (84 Assertions)**
- Rute terdaftar: 11 rute terdaftar dengan benar.
- Menjalankan `php artisan optimize:clear` untuk membersihkan cache bootstrap dan kompilasi template.

## Sprint 5: Checkout & Transactional Order Processing
**Tujuan**: Mengimplementasikan proses checkout yang aman, pengiriman kalkulasi server-side, simulasi metode pembayaran, penyimpanan ke database melalui transaksi yang mencegah race condition.

### Daftar Pekerjaan:
1. **Migration & Model Order**:
   - Membuat migration `orders` (id, fullname, phone, address, city, postal_code, subtotal, shipping_cost, total, payment_method, dll).
   - Membuat migration `order_items` dengan snapshoting (product_id, product_name, price, quantity, subtotal).
   - Membuat model `Order` dan `OrderItem` beserta relasinya.
2. **Kalkulasi Ongkos Kirim (ShippingService)**:
   - Membuat `App\Services\ShippingService` sebagai kalkulator ongkir dinamis yang bersifat deterministik di sisi server.
   - Mengubah rujukan legacy ongkir Javascript menjadi logika server-side (flat-rate Intra-kota, Intra-provinsi, Luar-provinsi berdasarkan pemetaan nama kota).
3. **Checkout Controller**:
   - Menambahkan rute `/checkout` (index, store, success).
   - `CheckoutController@index`: Merender tampilan daftar produk keranjang (memvalidasi stok server-side) dan form pengiriman.
   - `CheckoutController@store`: Memproses form dengan aman. Semua perhitugan total biaya bergantung pada data base Product dan `ShippingService` asli, mencegah price-spoofing dari pihak klien.
   - **Transaksi & Locking**: Membungkus operasi penyisipan dan pemotongan stok dengan `DB::transaction`. Menambahkan `lockForUpdate()` pada row produk untuk mencegah *race conditions* selama pengurangan persediaan. (Dibuat kondisional untuk environment SQLite automated testing).
   - Menangani `RuntimeException` apabila stok tidak mencukupi atau kuantitas cacat, mengirim error log dengan `Log::error` pada *unhandled Exceptions*.
4. **Halaman Frontend Checkout & Sukses**:
   - Merancang halaman `checkout/index.blade.php` dengan UI responsif.
   - Membuat halaman ringkasan `checkout/success.blade.php` pasca penyelesaian pembayaran.
5. **Testing**:
   - Membuat file `CheckoutTest.php` untuk meng-cover seluruh business logic: validasi stok, rollback transaksi, penanganan error form, nullablility *courier_note*, keranjang kosong, pengujian unit fungsi logistik, dsb.

### Hasil Pengujian & Pembersihan:
- Status Test Suite Keseluruhan: **36 Passed (158 Assertions)**
- Route terdaftar lengkap sesuai scope migrasi.
- Proses checkout dikonfirmasi bebas manipulasi harga/stok dari klien.
