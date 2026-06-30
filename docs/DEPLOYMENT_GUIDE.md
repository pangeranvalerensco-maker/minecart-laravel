# Panduan Hosting & Deploy di CWP 🚀

Dokumen ini berfungsi sebagai referensi untuk melakukan *deploy* aplikasi Laravel di **Control Web Panel (CWP)**, secara spesifik berfokus pada strategi meng-hosting **banyak aplikasi Laravel yang berbeda dalam satu subdomain** (atau domain utama) menggunakan sistem *routing* berbasis folder. 

Panduan ini akan sangat berguna sebagai konteks tambahan (referensi) bagi asisten AI di sesi *deployment* masa depan.

## 🏗️ Arsitektur: Banyak Aplikasi, Satu Subdomain

Pada *shared hosting* standar atau CWP, sebuah domain biasanya mengarah langsung ke folder `public_html`. Untuk menghosting banyak aplikasi (contoh: `minecart` dan `aplikasi-lain`) di domain yang sama (contoh: `http://domain-anda.com/minecart`), ikuti pemisahan struktur ini:

### 1. Folder Core / Inti (Dilindungi)
File-file inti Laravel (semua file KECUALI folder `public`) mengandung data sensitif (seperti file `.env`) dan **tidak boleh** bisa diakses langsung melalui web.
- Buat folder di luar atau terisolasi dari akses web utama (contoh: `public_html/minecart-core/`).
- Unggah semua folder Laravel (`app`, `bootstrap`, `config`, `database`, `resources`, `routes`, `storage`, `vendor`, `.env`) ke dalam `minecart-core/`.

### 2. Folder Public (Bisa Diakses Web)
Titik masuk (*entry point*) sebenarnya bagi pengguna adalah folder `public` milik Laravel.
- Buat folder untuk alamat URL yang Anda inginkan (contoh: `public_html/minecart/`).
- Unggah seluruh isi dari direktori `public` Laravel (`index.php`, `css/`, `js/`, `assets/`, `.htaccess`) ke dalam `public_html/minecart/`.

### 3. Menghubungkan Public ke Core (`index.php`)
Anda harus mengedit file `index.php` yang ada di dalam `public_html/minecart/` agar mengarah ke lokasi file-file *core* yang baru.

**Cari bagian ini:**
```php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
```

**Ubah menjadi (sesuaikan jalur/path dengan struktur folder Anda):**
```php
require __DIR__.'/../minecart-core/vendor/autoload.php';
$app = require_once __DIR__.'/../minecart-core/bootstrap/app.php';
```

*Catatan: Jalur pastinya (`../minecart-core/`) sangat bergantung pada di mana folder `minecart` dan `minecart-core` diletakkan relatif satu sama lain.*

## 🔒 Storage Link / Symlink di Shared Hosting
Laravel membutuhkan sebuah *symbolic link* dari `public/storage` ke `storage/app/public` agar gambar bisa ditampilkan. Di CWP/Shared Hosting yang tidak memiliki akses SSH:
1. Buat sebuah skrip PHP (misal: `symlink.php`) di dalam folder public (`public_html/minecart/`):
   ```php
   <?php
   $targetFolder = $_SERVER['DOCUMENT_ROOT'].'/minecart-core/storage/app/public';
   $linkFolder = $_SERVER['DOCUMENT_ROOT'].'/minecart/storage';
   symlink($targetFolder, $linkFolder);
   echo 'Proses Symlink Berhasil';
   ?>
   ```
2. Kunjungi URL `http://domain-anda.com/minecart/symlink.php` di browser Anda.
3. Hapus skrip tersebut setelah sukses.

## 🔧 Konfigurasi Environment (`.env`)
Saat memindahkan proyek ke CWP, ingatlah untuk memperbarui file `.env` yang berlokasi di `minecart-core/`:
- **APP_URL**: Ubah dari `http://127.0.0.1:8000` menjadi `http://domain-anda.com/minecart`
- **Pengaturan DB**: Perbarui `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` agar cocok dengan Database MySQL yang dibuat di panel CWP.
- **Cache**: Jika Anda mengubah `.env` di tahap *production*, Anda **wajib** menghapus cache konfigurasi. Di File Manager, hapus file `minecart-core/bootstrap/cache/config.php`.

## ⚠️ Keunikan & Masalah Umum di CWP
- **Hak Akses File (Permissions)**: Jika Anda menemui Error 500 (Internal Server Error), pastikan hak akses file diatur ke `644` dan folder ke `755`. Di CWP, Anda bisa menggunakan alat "Fix Permissions".
- **Iklan Hosting Terselubung**: Penyedia *hosting* gratis sering kali menyuntikkan HTML/Script (seperti *footer* iklan yang melayang) tepat sebelum tag penutup `</body>`. Jika ini merusak tampilan (*layout*) Anda, gunakan CSS (`display: none !important`) atau JavaScript untuk menyembunyikan elemen iklan tersebut.
- **Redirect Google OAuth**: Jika Anda mendapat pesan `redirect_uri_mismatch` Error 400, itu berarti Google masih mencari URL lama `127.0.0.1`. Buka Google Cloud Console dan tambahkan URL *production* CWP Anda ke daftar "Authorized redirect URIs".
