# MineCart 🛒

MineCart adalah aplikasi web E-Commerce modern dengan fitur lengkap yang dibangun menggunakan **Laravel**. Proyek ini menampilkan desain **Neo-Brutalism** yang unik dengan fitur *toggle* (sakelar) yang mulus untuk beralih ke mode gelap "Mining/Cave", memberikan pengalaman berbelanja yang sangat menarik secara visual.

## ✨ Fitur-Fitur

- **Autentikasi Multi-Peran**: Login/Pendaftaran pengguna standar, ditambah integrasi **Google OAuth** menggunakan Laravel Socialite.
- **Fitur Multi-Vendor**: Pengguna dapat meng-upgrade akun mereka untuk membuka toko sendiri (`is_seller`), mengelola produk, dan melihat halaman toko mereka sendiri.
- **Pengalaman Berbelanja yang Lengkap**:
  - Keranjang Belanja & *Preview* Keranjang Dinamis
  - Sistem *Wishlist* (Daftar Keinginan)
  - Riwayat & Pelacakan Pesanan
  - Pencarian & Filter Produk *Real-time* (dilengkapi Pagination)
- **Integrasi Payment Gateway (Gerbang Pembayaran)**: 
  - **Midtrans**: Untuk proses *checkout* yang aman dan lancar.
  - **Xendit**: Alternatif integrasi pembayaran (Tahap Pengembangan).
- **UI/UX Interaktif**:
  - Estetika Neo-Brutalism dengan garis pinggir yang tegas, tipografi tebal, dan bayangan datar.
  - Sakelar Mode Gelap / Mode Terang dengan variabel CSS dinamis.
  - Dukungan Multi-bahasa (Bahasa Indonesia & English).
- **Sistem Live Chat**: Pesan langsung antara pembeli dan penjual.

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel 10.x / 11.x, PHP 8+
- **Frontend**: HTML5, Blade Templates, Vanilla CSS (Neo-Brutalism), Vanilla JavaScript
- **Database**: MySQL
- **Integrasi Eksternal**: 
  - Midtrans API (Pembayaran)
  - Xendit API (Pembayaran)
  - Google Socialite (Autentikasi)

## 📂 Struktur Proyek

- `/app/Http/Controllers` - Logika inti untuk Produk, Keranjang, Checkout, Chat, dan Manajemen Penjual.
- `/resources/views` - *Template* Blade, menggunakan potongan file yang dapat digunakan ulang (`header`, `footer`) dan *layout* utama.
- `/public/css` - Lembar gaya (CSS) global, termasuk `style.css` (inti desain Neo-Brutalism) dan `seller.css`.
- `/docs` - Dokumentasi tambahan untuk referensi sesi AI, *deployment*, dan rencana masa depan.

## 🚀 Cara Menjalankan di Lokal (Local Development)

1. *Clone repository* ini:
   ```bash
   git clone https://github.com/username-anda/minecart-laravel.git
   cd minecart-laravel
   ```
2. Instal dependensi:
   ```bash
   composer install
   npm install && npm run build
   ```
3. Pengaturan *Environment*:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Atur file `.env` Anda dengan kredensial Database, kunci Midtrans, dan Client ID Google.*
4. Jalankan Migration & Seeder:
   ```bash
   php artisan migrate --seed
   ```
5. Jalankan aplikasi:
   ```bash
   php artisan serve
   ```

## 📖 Dokumentasi Lanjutan

Untuk panduan teknis yang lebih detail, silakan merujuk ke folder `/docs`:
- [Rencana Masa Depan & Optimasi Mobile](docs/FUTURE_PLANS.md)
- [Panduan Hosting & Deploy di CWP](docs/DEPLOYMENT_GUIDE.md)
- [Panduan Manajemen Produk & Skalabilitas](docs/PRODUCT_MANAGEMENT.md)

---
*Dibuat oleh Pangeran Valerensco Rivaldi Hutabarat*
