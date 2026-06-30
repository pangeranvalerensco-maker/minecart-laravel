# Rencana Masa Depan & Optimasi Mobile 📱

Dokumen ini berfungsi sebagai peta jalan (*roadmap*) untuk siklus pengembangan **MineCart** selanjutnya, dengan penekanan utama pada perbaikan Pengalaman Pengguna (UX) di perangkat *Mobile* dan perluasan fitur-fitur inti.

## 1. Perombakan UX Mobile-First (Prioritas Tinggi)
Saat ini, website sudah berfungsi di HP, tetapi tata letaknya membutuhkan perbaikan signifikan untuk mencegah elemen yang bertumpuk ("tembus-tembus") dan meningkatkan kenyamanan penggunaan.

**Tindakan yang Direncanakan:**
- **Navigasi & Header:**
  - Mendesain ulang menu *hamburger* di versi *mobile* menjadi *drawer* (laci) di samping layar atau *modal* layar penuh yang elegan.
  - Menerapkan *sticky header* pada *mobile* yang akan bersembunyi saat di-*scroll* ke bawah dan muncul saat di-*scroll* ke atas untuk memaksimalkan area layar.
- **Grid Produk:**
  - Mengubah tampilan multi-kolom di desktop menjadi tata letak 2 kolom atau 1 kolom yang dioptimalkan untuk layar *mobile*.
  - Memastikan kartu produk memiliki area sentuh (*touch target*) yang layak (minimal 44x44px untuk tombol seperti "Tambah ke Keranjang").
- **Spasi & Padding:**
  - Mengaudit semua *container*. Mengurangi *padding/gap* yang berlebihan (misal: `gap: 30px` -> `gap: 10px`) untuk ukuran layar di bawah 768px.
  - Memperbaiki teks yang tumpang tindih di bagian *Hero* dengan menerapkan penskalaan font dinamis (menggunakan properti `clamp()`).
- **Alur Checkout:**
  - Menyederhanakan formulir *checkout* di *mobile* menjadi langkah-langkah *wizard* (step-by-step).
  - Mengoptimalkan *modal/popup* pembayaran Midtrans agar tidak meluap keluar dari layar kecil.

## 2. Penambahan Fitur

**Jangka Pendek:**
- **Ulasan & Rating Produk:** Memungkinkan pembeli untuk memberikan ulasan teks dan rating 1-5 bintang setelah pembelian berhasil.
- **Pelacakan Pesanan:** Mengintegrasikan *timeline* status pengiriman dasar (contoh: Dikemas, Dikirim, Diterima) pada Riwayat Pesanan pengguna.
- **Peningkatan Cache:** Menerapkan Redis atau Memcached untuk pencarian produk dan manajemen sesi yang lebih cepat.

**Jangka Panjang:**
- **Dashboard Admin:** Backend khusus bagi pemilik situs (Admin) untuk mengelola pengguna, memblokir penjual curang, dan melihat analitik platform.
- **Pembayaran Otomatis (Payout):** Mengintegrasikan sistem *Disbursements* Xendit/Midtrans untuk mencairkan dana secara otomatis ke rekening penjual setelah pesanan ditandai "Selesai".
- **Pencarian Canggih:** Menerapkan Algolia atau Elasticsearch untuk hasil pencarian instan yang toleran terhadap salah ketik (typo).

## 3. Pemeliharaan Kode Base
- Memigrasikan CSS murni (*vanilla*) ke dalam *pre-processor* (seperti SASS) atau *framework* utilitas (seperti Tailwind CSS) agar lebih mudah dikembangkan, jika diperlukan.
- Menerapkan pengujian otomatis yang komprehensif (PHPUnit/Pest) khususnya untuk alur Checkout dan Autentikasi.
