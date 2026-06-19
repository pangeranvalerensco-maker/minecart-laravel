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
