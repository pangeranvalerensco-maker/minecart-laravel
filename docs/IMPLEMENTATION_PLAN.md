# Implementation Plan: MineCart Migration

Rencana pelaksanaan ini membagi proses migrasi MineCart dari web statis ke monolithic Laravel 12 menjadi beberapa tahap kecil yang terukur dan terstruktur.

---

## Tahap 1: Fondasi Blade & Migrasi Aset
- **Langkah 1.1**: Salin semua file dari `minecart-legacy/assets` ke `minecart-laravel/public/assets`.
- **Langkah 1.2**: Buat direktori `docs/` di proyek Laravel dan simpan kelima file dokumentasi di dalamnya.
- **Langkah 1.3**: Konfigurasikan Vite (`vite.config.js`) untuk memproses file CSS dan JavaScript utama (jika menggunakan struktur aset Laravel standar).
- **Langkah 1.4**: Buat file kamus terjemahan bahasa (ID & EN) di `lang/id/messages.php` dan `lang/en/messages.php` berdasarkan kamus bahasa statis di `minecart-legacy/js/script.js`.

---

## Tahap 2: Layout Utama (Header, Footer, & Navigation)
- **Langkah 2.1**: Buat layout induk `resources/views/layouts/app.blade.php`.
- **Langkah 2.2**: Salin CSS dari `minecart-legacy/css/style.css` ke `resources/css/app.css` (atau simpan langsung di `public/css/style.css` untuk kemudahan pemuatan statis).
- **Langkah 2.3**: Buat komponen partial `resources/views/partials/header.blade.php` dan `resources/views/partials/footer.blade.php`.
- **Langkah 2.4**: Implementasikan JavaScript untuk menu hamburger mobile, theme toggle (menyimpan preferensi ke cookie agar tidak terjadi flicker), dan language dropdown.

---

## Tahap 3: Halaman Beranda (Homepage)
- **Langkah 3.1**: Buat `HomeController` untuk menangani rute `/`.
- **Langkah 3.2**: Buat view `resources/views/home.blade.php` yang memperluas layout utama.
- **Langkah 3.3**: Migrasikan markup dan logic JavaScript untuk **Hero Carousel** dengan 3 slide gambar bawaan.
- **Langkah 3.4**: Integrasikan popup sambutan Customer Service (CS) yang dinamis menggunakan localStorage/cookie.
- **Langkah 3.5**: Buat elemen Toast Notification Container untuk menampilkan umpan balik interaktif.

---

## Tahap 4: Database Kategori & Produk
- **Langkah 4.1**: Buat migrasi untuk tabel `categories` dan `products`.
- **Langkah 4.2**: Buat model Eloquent `Category` dan `Product` beserta relasinya.
- **Langkah 4.3**: Buat `DatabaseSeeder` yang mengambil data produk dari API JSON eksternal `https://my-api-theta-three.vercel.app/pangeran/api` menggunakan HTTP Client Laravel (`Http::get`) lalu memasukkannya ke database PostgreSQL, atau lakukan seeding manual berdasarkan skema data API agar database selalu terisi lokal.

---

## Tahap 5: Katalog Produk & Halaman Detail
- **Langkah 5.1**: Buat `ProductController` untuk menangani katalog dan halaman detail produk.
- **Langkah 5.2**: Buat view `resources/views/products/index.blade.php` untuk menampilkan daftar produk dengan filter kategori dan pencarian.
- **Langkah 5.3**: Implementasikan fitur sorting (harga, nama, stok, dan lokasi terdekat) di sisi server (PHP/SQL query).
- **Langkah 5.4**: Buat view `resources/views/products/show.blade.php` untuk detail produk (menampilkan deskripsi multi-bahasa, status stok dinamis, dan produk terkait).

---

## Tahap 6: Keranjang Belanja berbasis Laravel Session
- **Langkah 6.1**: Buat `CartController` dan definisikan rute untuk menampilkan, menambah, memperbarui, dan menghapus item keranjang.
- **Langkah 6.2**: Gunakan PHP Session (`session('cart', [])`) untuk menyimpan state keranjang.
- **Langkah 6.3**: Buat view `resources/views/cart.blade.php`. Implementasikan fungsionalitas:
  - Mengubah kuantitas item (+/-) dengan validasi batas stok maksimal.
  - Menghapus item dari keranjang.
  - Memilih item tertentu menggunakan checkbox.
- **Langkah 6.4**: Pindahkan rumus perhitungan ongkos kirim dan estimasi waktu dari JS lama ke Helper/Service PHP di server. Hitung tarif berdasarkan kota asal produk dan kota tujuan masukan pengguna.

---

## Tahap 7: Formulir Pengiriman & Simulasi Checkout
- **Langkah 7.1**: Buat `CheckoutController` untuk rute `/checkout`.
- **Langkah 7.2**: Buat view `resources/views/checkout.blade.php` yang menampilkan produk terpilih, form alamat lengkap pengirim, rincian biaya (subtotal + ongkir), dan opsi metode pembayaran.
- **Langkah 7.3**: Validasi input alamat dan metode pembayaran sebelum memproses order.

---

## Tahap 8: Penyimpanan Pesanan & Transaksi Berhasil
- **Langkah 8.1**: Buat migrasi database untuk tabel `orders` dan `order_items`.
- **Langkah 8.2**: Buat model Eloquent `Order` dan `OrderItem`.
- **Langkah 8.3**: Di `CheckoutController@store`, buat logic pemrosesan order dalam transaksi database (`DB::transaction`):
  1. Validasi stok akhir produk di database.
  2. Simpan record baru ke tabel `orders`.
  3. Simpan relasi detail item ke tabel `order_items`.
  4. Potong jumlah stok produk di tabel `products`.
  5. Hapus item terkait dari session keranjang.
- **Langkah 8.4**: Buat view `resources/views/checkout/success.blade.php` untuk menampilkan bukti order berhasil, mainkan audio `minecart-sound.m4a` lewat JS pada pemuatan halaman, dan sediakan redirect otomatis kembali ke halaman utama.

---

## Tahap 9: Pengujian & Perapihan (Finishing)
- **Langkah 9.1**: Lakukan pengujian manual untuk seluruh alur: dari homepage, pencarian produk, penyaringan kategori, detail, tambah ke keranjang, simulasi ongkir, checkout, hingga transaksi sukses.
- **Langkah 9.2**: Validasi keakuratan stok produk pasca checkout (stok terpotong dengan benar).
- **Langkah 9.3**: Pastikan CSS layouting responsif dan sinkronisasi tema gelap/terang bekerja tanpa kendala layout berantakan.
- **Langkah 9.4**: Bersihkan kode penunjang sementara (clean up debug logs).
