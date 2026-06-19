# Feature Scope & Migration Plan

Dokumen ini mendefinisikan cakupan fitur aplikasi **MineCart** hasil migrasi, bagaimana fitur tersebut bekerja di aplikasi monolithic Laravel Blade, serta pemetaan integrasi frontend-backend.

## 1. Daftar Halaman & Rute Aplikasi

Dalam migrasi ke Laravel, 11 file HTML lama akan dikonsolidasikan dan dipetakan menjadi rute-rute berikut:

| Rute URL | Nama Rute | Halaman / Konten | Controller & Action | Catatan |
| :--- | :--- | :--- | :--- | :--- |
| `/` | `home` | Beranda (Homepage) | `HomeController@index` | Menampilkan hero carousel & rekomendasi produk. |
| `/products` | `products.index` | Katalog Produk (Catalog) | `ProductController@index` | Pencarian, kategori filter, dan pengurutan (sorting). |
| `/products/{id}` | `products.show` | Detail Produk (Detail) | `ProductController@show` | Foto, detail stok/harga, deskripsi dwi-bahasa, related products. |
| `/cart` | `cart.index` | Keranjang Belanja (Cart)| `CartController@index` | Menampilkan item keranjang, subtotal, form pengiriman. |
| `/cart/add/{id}` | `cart.add` | Tambah Produk ke Keranjang | `CartController@add` | Menambahkan item ke session keranjang (validasi stok). |
| `/cart/update/{id}` | `cart.update` | Ubah Kuantitas Item | `CartController@update` | AJAX/Form untuk menaikkan/menurunkan jumlah item. |
| `/cart/remove/{id}` | `cart.destroy` | Hapus Item dari Keranjang | `CartController@destroy` | Menghapus item tertentu dari session keranjang. |
| `/checkout` | `checkout.index` | Formulir Checkout | `CheckoutController@index` | Menampilkan item yang dicentang, total ongkir, pilihan pembayaran. |
| `/checkout/process` | `checkout.store` | Proses Checkout | `CheckoutController@store` | Menyimpan ke tabel `orders` & `order_items`, potong stok. |
| `/checkout/success` | `checkout.success` | Status Transaksi Berhasil | `CheckoutController@success` | Menampilkan ringkasan pesanan & redirect otomatis. |
| `/about` | `about` | Tentang Kami | `StaticPageController@about` | Halaman statis tim pengembang. |
| `/help` | `help` | Bantuan (FAQ) | `StaticPageController@help` | Halaman statis FAQ interaktif. |
| `/account` | `account` | Akun Saya | `AccountController@index` | Mengubah informasi profil & alamat (disimulasikan). |

## 2. Rincian Fitur Utama

### A. Beranda (Homepage)
- **Hero Carousel**: Slider gambar 3 slide (`carousel-1.jpg`, `carousel-2.jpg`, `carousel-3.jpg`) dengan transisi otomatis 5 detik, serta tombol manual prev/next.
- **Rekomendasi Produk**: Menampilkan grid produk dengan rating/rekomendasi tertinggi (diambil dari database PostgreSQL).
- **Popup Customer Service**: Popup selamat datang yang muncul setelah 2 detik pada kunjungan pertama. Status ditutup disimpan di cookie atau localStorage.
- **Multilingual & Theme Toggle**: Tombol pengubah bahasa (ID/EN) dan tombol pengubah tema (Light/Dark mode) yang diletakkan di header dan disinkronkan ke seluruh halaman.

### B. Katalog & Pencarian Produk
- **Category Filter**: Filter dinamis berdasarkan kategori yang tersedia di database.
- **Sorting Options**: Pengurutan berdasarkan:
  - Harga (Terendah ke Tertinggi, Tertinggi ke Terendah)
  - Nama (A-Z, Z-A)
  - Stok (Terbanyak, Terendah)
  - Lokasi Produk (Terdekat, Terjauh) — dihitung menggunakan string kemiripan lokasi pengguna.
- **Search Bar**: Pencarian text-matching di database PostgreSQL terhadap kolom judul/deskripsi (baik versi ID maupun EN).

### C. Detail Produk
- **Galeri Gambar**: Klik thumbnail gambar produk untuk mengubah gambar utama.
- **Informasi Produk**: Judul, deskripsi, harga, status stok aktual dari database, serta lokasi asal pengiriman produk.
- **Validasi Stok**: Tombol "+" dinonaktifkan secara dinamis jika jumlah yang ingin dibeli melebihi stok database.
- **Rekomendasi Terkait**: Menampilkan produk alternatif dalam kategori yang sama.

### D. Keranjang Belanja (Laravel Session)
- **Penyimpanan**: Menggunakan session Laravel (`session('cart')`) dalam bentuk array asosiatif:
  ```php
  [
      'items' => [
          ['product_id' => 1, 'quantity' => 2],
          ['product_id' => 3, 'quantity' => 1]
      ],
      'selected_ids' => [1, 3] // Id item yang dicentang untuk checkout
  ]
  ```
- **Fungsi Kelola**: Ubah kuantitas via tombol AJAX `+/-` (disertai validasi batas stok server-side) dan hapus item dari keranjang.
- **Pilih Semua (Select All)**: Checkbox untuk mencentang seluruh item atau item tertentu saja yang ingin diproses ke checkout.
- **Simulasi Alamat & Ongkir**: Pengguna mengisi form alamat pengiriman. Sistem menghitung ongkos kirim secara dinamis di server berdasarkan kota asal produk vs kota tujuan (menggunakan basis data ongkir flat-rate dari file JS lama).

### E. Checkout & Simulasi Pembayaran ✅ [SELESAI]
- **Data Pesanan**: Menampilkan daftar item terpilih, alamat pengiriman yang dimasukkan di halaman keranjang, dan rincian total biaya. (Harga, ongkir, total, dan validasi stok seluruhnya dihitung aman secara server-side).
- **Metode Pembayaran**: Opsi pembayaran simulasi (Transfer Bank, COD, E-Wallet).
- **Proses Transaksi**: Setelah tombol "Selesaikan Pembayaran" diklik:
  1. Melakukan transaksi database (DB transaction) untuk mencegah inkonsistensi.
  2. Memeriksa ketersediaan stok produk terbaru (memanfaatkan locking).
  3. Mengurangi stok produk di tabel `products`.
  4. Menyimpan data order ke `orders` dan `order_items` (menyimpan snapshot nama produk dan harga).
  5. Menghapus item yang dibeli dari session keranjang.
  6. Mengarahkan pengguna ke halaman transaksi berhasil.

### F. Halaman Transaksi Berhasil (Order Success) ✅ [SELESAI]
- Menampilkan pesan sukses bertema pixel-art MineCraft khas.
- Menampilkan ID Transaksi, detail item yang dipesan, dan total pembayaran.
- Redirect otomatis kembali ke Beranda setelah beberapa detik, dilengkapi dengan audio soundeffect MineCart (`minecart-sound.m4a`) yang dimainkan saat pemuatan halaman sukses.

## 3. Komponen Pendukung Visual & Interaktif
- **Toast Notifications**: Notifikasi pop-up kecil di bagian atas layar untuk memberi tahu pengguna ketika berhasil menambah produk ke keranjang, stok tidak cukup, atau terjadi error lainnya.
- **Language Switcher (Dua Bahasa)**: Penerjemahan teks statis menggunakan Laravel Localization (file bahasa di `lang/id/messages.php` dan `lang/en/messages.php`). Pilihan bahasa disimpan dalam session/cookie.
- **Theme Switcher**: Menyimpan preferensi tema (dark/light) ke Cookie sehingga saat server merender halaman baru, server langsung memberikan class `.dark-mode` pada tag `<body>` sebelum halaman dirender untuk menghindari kedipan layar (flash of unstyled content).
