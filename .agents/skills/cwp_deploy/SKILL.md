---
name: CWP Laravel Deployment
description: Panduan dan aturan untuk melakukan deploy aplikasi Laravel di Control Web Panel (CWP), memisahkan core dan public, serta mengatasi cache statis.
---

# Panduan Deployment Laravel di CWP (Control Web Panel)

Skill ini digunakan setiap kali user meminta bantuan untuk menyiapkan, memigrasikan, atau memperbaiki masalah deployment Laravel di CWP.

## 1. Arsitektur Folder (Core vs Public)
- Di CWP, satu akun/subdomain biasanya diarahkan ke folder `public_html/folder_app`.
- Jangan menaruh file `.env` dan direktori inti Laravel di dalam folder yang dapat diakses publik.
- **Pemisahan:**
  - `core` folder (misal: `public_html/minecart-core/`): Berisi seluruh instalasi Laravel kecuali folder `public`.
  - `public` folder (misal: `public_html/minecart/`): Berisi isi dari folder `public` bawaan Laravel (`index.php`, CSS, JS, dll).

## 2. Modifikasi index.php
Setelah dipisahkan, file `index.php` di folder public harus disesuaikan jalurnya agar menunjuk ke folder core yang benar:
```php
require __DIR__.'/../minecart-core/vendor/autoload.php';
$app = require_once __DIR__.'/../minecart-core/bootstrap/app.php';
```

## 3. Bypass Cache Statis (CSS/JS)
- Browser sering melakukan cache ekstensif pada file CSS dan JS.
- Jika ada perubahan tampilan namun tidak terlihat di web, modifikasi `app.blade.php` atau file layout utama dengan menambahkan parameter versi query string pada asset, contoh: `href="{{ asset('css/style.css') }}?v=2.0"`.

## 4. Google OAuth Mismatch
- Jika terjadi Error 400 `redirect_uri_mismatch` saat menggunakan Socialite, ini BUKAN error kode, melainkan URL callback di Google Cloud Console belum diupdate ke domain production (masih 127.0.0.1). Arahkan user untuk menambahkan URL production ke "Authorized redirect URIs".
