# Project Context: MineCart Migration

Dokumen ini mendefinisikan latar belakang, arsitektur, dan konteks migrasi untuk proyek E-Commerce **MineCart**.

## 1. Latar Belakang & Tujuan
Proyek **MineCart** bermula dari sebuah website e-commerce berbasis client-side murni (HTML, CSS, JavaScript) yang menyimpan data keranjang, akun pengguna, dan riwayat pesanan menggunakan `localStorage`, serta mengambil katalog produk dari API JSON eksternal.

Tujuan utama dari proyek ini adalah memigrasikan website MineCart lama menjadi aplikasi e-commerce monolithic modern berbasis **Laravel 12** dalam waktu satu minggu. Aplikasi baru ini akan memanfaatkan pemrosesan server-side, database PostgreSQL, dan template engine Blade, sambil mempertahankan desain visual serta pengalaman pengguna yang khas dari website lama.

## 2. Spesifikasi Teknologi Final
- **Framework Utama**: Laravel 12
- **Bahasa Pemrograman**: PHP 8.2 (Backend) & Vanilla JavaScript (Frontend)
- **Database**: PostgreSQL (menggunakan Laravel Eloquent ORM)
- **Template Engine**: Laravel Blade (untuk routing, layouting, rendering)
- **Sistem Keranjang**: Laravel Session (tidak menggunakan tabel database)
- **Asset Bundler**: Vite (bawaan Laravel 12)
- **Styling**: Vanilla CSS (menggunakan CSS Variables dari proyek lama, diintegrasikan ke dalam aset Laravel)

## 3. Batasan & Larangan Keras
Selama proses migrasi, beberapa aturan dan larangan berikut harus dipatuhi:
- **TIDAK boleh** menggunakan framework SPA/reaktif modern seperti React, Vue, Livewire, atau Inertia.js. Interaktivitas sisi klien harus menggunakan Vanilla JavaScript bawaan.
- **TIDAK boleh** menggunakan arsitektur microservices atau REST API dengan otentikasi JWT untuk aplikasi utama. Semua rendering bersifat server-side monolithic.
- **TIDAK boleh** menggunakan Docker (aplikasi berjalan di local environment PHP & PostgreSQL bawaan).
- **TIDAK boleh** menggunakan payment gateway asli (seperti Midtrans, Stripe). Semua proses pembayaran disimulasikan secara lokal.
- **TIDAK boleh** mengubah file konfigurasi lingkungan `.env` secara manual di luar konfigurasi dasar database (dan dilarang memodifikasi .env yang disediakan secara langsung jika tidak diperlukan).
- **TIDAK boleh** memodifikasi folder referensi `minecart-legacy`.
- **TIDAK boleh** melakukan git commit atau git push di repo ini.
- **TIDAK boleh** mengubah kode aplikasi utama Laravel sebelum dokumentasi ini disetujui.

## 4. Perbandingan Sistem: Lama vs. Baru

| Komponen | Sistem Lama (Legacy) | Sistem Baru (Laravel 12) |
| :--- | :--- | :--- |
| **Arsitektur** | SPA Client-Side Statis | Monolithic MVC Server-Side |
| **Sumber Data Produk** | API JSON Eksternal (Vercel) | PostgreSQL Database (Model `Product`, `Category`) |
| **Penyimpanan Keranjang**| `localStorage` (`cart_[username]`) | Laravel Session (`session('cart', [])`) |
| **Otentikasi Pengguna** | Simulasi lokal (`userAccounts` di `localStorage`) | Laravel Session / Standard Authentication (jika diperlukan) |
| **Ongkir & Estimasi** | JavaScript client-side (fungsi hitung tarif statis) | PHP Controller Server-Side (berdasarkan lokasi toko & pengguna) |
| **Data Transaksi** | Tidak disimpan permanen (simulasi sessionStorage) | PostgreSQL Database (Tabel `orders` & `order_items`) |
| **Layout & Templating** | Duplikasi markup di 11 file HTML terpisah | Blade Layouts (`app.blade.php`), Partials (`header`, `footer`) |

## 5. Komponen yang Dipertahankan & Diganti

### Bagian yang Dipertahankan
- **Style CSS (`css/style.css`)**: Struktur CSS lengkap dengan tema terang ("Overworld") dan tema gelap ("Cave") menggunakan CSS Variables (`--body-bg`, `--accent-color`, dll.) akan dipertahankan sepenuhnya demi menjaga identitas visual MineCraft-like.
- **Interaktivitas JavaScript Sederhana (`js/script.js`)**: Logika transisi slide carousel, toggle bahasa, toggle tema (dark-mode), popup selamat datang CS, serta styling popup toast akan dipertahankan dengan penyesuaian selektor Blade.
- **Aset Gambar dan Media (`assets/*`)**: Semua file JPG, PNG, WEBP, video MP4, dan klip audio M4A akan dipindahkan ke folder `public/assets` atau `storage` Laravel untuk disajikan langsung ke klien.

### Bagian yang Harus Diganti
- **Struktur Halaman HTML**: Seluruh 11 file HTML akan dipecah menjadi file Blade template yang terstruktur di dalam `resources/views/` (menggunakan Blade layouting `@extends` dan `@section`).
- **Logika Keranjang Belanja**: Logika manipulasi array keranjang di JavaScript digantikan oleh routing Laravel Controller yang memodifikasi array keranjang di dalam `session()`.
- **Manajemen State Stok & Checkout**: Pengurangan stok pasca order dan validasi ketersediaan stok akan ditangani oleh transaksi database server-side, bukan simulasi local array.
- **Simulasi Ongkir & Waktu Pengiriman**: Fungsi penghitungan jarak dan tarif statis akan dipindahkan ke Laravel Helper/Service di sisi PHP, sehingga data alamat tujuan dikirimkan via form submission atau AJAX request, kemudian ongkir dihitung secara akurat di server sebelum checkout.
- **Penyimpanan Pesanan**: Pesanan baru akan dimasukkan secara permanen ke dalam tabel database relasional PostgreSQL melalui Eloquent ORM.
