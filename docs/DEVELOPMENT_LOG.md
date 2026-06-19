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
