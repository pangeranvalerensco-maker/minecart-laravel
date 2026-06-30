# Panduan Manajemen Produk & Skalabilitas 📦

Seiring berkembangnya platform MineCart, menambahkan produk satu per satu secara manual lewat halaman web akan terasa sangat melelahkan, terutama jika Anda harus memigrasikan lebih dari 100+ barang. Dokumen ini menjelaskan pendekatan terbaik untuk manajemen produk secara massal (*bulk*) dan memberikan panduan bagi asisten AI yang akan mengerjakan fitur ini di masa depan.

## Kondisi Saat Ini
Saat ini, MineCart memungkinkan penambahan produk secara manual lewat antarmuka web (UI). Hal ini berfungsi baik untuk masing-masing penjual, tetapi sangat tidak efisien bagi pemilik platform yang ingin mengisi katalog awal.

## Opsi untuk Memasukkan Produk Secara Massal

### 1. Database Seeding (Cara Developer)
Jika Anda sudah memiliki daftar produk yang terstruktur (contoh: dalam format JSON atau CSV), cara paling rapi untuk memasukkannya adalah melalui *Seeder* Laravel.

**Bagaimana AI harus menangani ini:**
- Parsing/Bongkar data JSON/CSV milik pengguna.
- Buat *Seeder* khusus (contoh: `php artisan make:seeder BulkProductSeeder`).
- Gunakan Eloquent ORM Laravel untuk melakukan *looping* (perulangan) pada data tersebut dan memasukkannya ke tabel `products`.
- **Penting:** Pastikan *foreign key* (seperti `user_id` untuk penjual, dan `category_id`) sudah ada di database sebelum memasukkan data untuk menghindari error *constraint violation*.
- Jalankan seeder dengan `php artisan db:seed --class=BulkProductSeeder`.

### 2. Import Langsung ke MySQL (Cara Paling Cepat)
Jika Anda memindahkan data dari database lama atau memiliki *dump* SQL (seperti *output* dari `export_db.php`), Anda dapat mengimpornya langsung ke phpMyAdmin di panel CWP.
- **Peringatan:** Melakukan import langsung ke Database akan melewati fitur-fitur "Event" Eloquent Laravel (seperti fitur otomatis membuat *slug*, *hashing* data, atau memicu sistem *webhook*). Pastikan *dump* SQL tersebut bentuk strukturnya (kolomnya) 100% cocok dengan tabel `products` saat ini.

### 3. Membangun API Import Massal (Cara Jangka Panjang / Skalabel)
Untuk pengelolaan jangka panjang, pendekatan terbaik adalah membangun sebuah *API endpoint* atau antarmuka *Admin* khusus yang dapat menerima unggahan (*upload*) file CSV.

**Rencana Implementasi Masa Depan untuk AI:**
1. **Route:** Buat rute `POST /admin/products/import` yang dilindungi oleh *middleware* Admin.
2. **Controller:** Buat file `ProductImportController`.
3. **Logika:** Gunakan *package*/paket seperti [Laravel Excel (maatwebsite/excel)](https://laravel-excel.com/) untuk membaca file CSV/Excel yang diunggah.
4. **Validasi:** Pastikan CSV tersebut memiliki judul kolom yang wajib ada: `name`, `description`, `price`, `stock`, `category_id`.
5. **Gambar (Images):** Mengimpor gambar secara massal lumayan rumit. CSV harus berisi URL gambar. Controller harus memilih antara: menyimpan URL tersebut sebagai teks (jika *hotlinking*/link luar diizinkan) atau menggunakan PHP untuk mengunduh dan menyimpan gambar tersebut secara lokal ke `/storage/app/public/products/`.

## Catatan tentang Error 404 Gambar "OIP..."
Pada masa awal pengembangan, beberapa produk tiruan (*dummy*) dibuat menggunakan URL Gambar dari Bing yang terpotong (selalu diawali dengan `OIP...`). Tautan-tautan ini sudah rusak dan akan menyebabkan peringatan error 404 merah di konsol browser.
- **Solusi/Fix:** Cukup hapus produk-produk *dummy* tersebut dari database, atau perbarui kolom `image` mereka dengan *path* (jalur) lokal yang valid (contoh: `products/sample.jpg`) atau URL gambar luar yang benar-benar aktif.
