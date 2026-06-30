# 🚀 Handoff Document: Fase 4 (Administratif & Analytics)

## 📌 Status Terkini (Current State)
Hingga saat ini, aplikasi MineCart telah berhasil menyelesaikan Fase 1 hingga Fase 3 secara penuh dengan status **Production-Ready**:
1. **Frontend & UI/UX**:
   - Tema Gelap/Terang (*Dark Mode*) sudah berjalan dengan mulus menggunakan CSS variables (`style.css`) dan Vanilla JS (`ui.js`). Logo sudah menyesuaikan (*invert*) saat *dark mode*.
   - Fitur Multi-bahasa (Indonesia/Inggris) berjalan penuh (tidak me-refresh halaman, AJAX style).
   - Animasi *micro-interaction* di tombol *checkout*, tombol keranjang, dll sudah rapi.

2. **Backend & Alur Belanja**:
   - Sistem *Cart* (Keranjang Belanja) berbasis sesi (*database*) sudah beroperasi tanpa me-refresh halaman (AJAX API call).
   - Proses Checkout (*Checkout Flow*) sudah selesai dan stabil.
   - **Xendit Payment Gateway Integration**: Telah terhubung. Saat *checkout*, status pesanan menjadi `pending`, URL tagihan (*invoice*) di-*generate*, keranjang dibersihkan. Tagihan ini ditautkan dengan tombol "Bayar Sekarang" di menu *Order History* pengguna.

## 🎯 Target Selanjutnya (Fase 4: Administratif & Analytics)
Untuk AI di sesi selanjutnya, Anda ditugaskan untuk mulai mengerjakan **Fase 4**. Fase ini berfokus pada sisi Pemilik Toko (Seller) dan Pemilik Sistem (Superadmin). Berikut rinciannya:

### 1. Superadmin Dashboard
- **Role System**: Tambahkan mekanisme untuk membedakan *user* biasa, *seller*, dan *superadmin*. (Misal: kolom `role` = 'user', 'seller', 'superadmin' di tabel `users`).
- **Admin Panel**: Buat *layout* terpisah (contoh: `resources/views/admin/layout.blade.php`) untuk Superadmin.
- **Fitur**: Superadmin dapat melihat rekap total semua transaksi dari semua toko, mengelola pengguna (blokir pengguna/toko), dan mengatur persentase komisi platform.

### 2. Sistem Dompet (Wallet) & Penarikan Dana (Withdrawal)
- **Konsep Escrow**: Pembayaran pesanan Xendit masuk ke akun *platform* (MineCart). Dana tersebut menjadi saldo virtual (Wallet) untuk Seller.
- Saldo hanya bisa ditarik jika status pesanan sudah "Selesai" (Barang diterima pembeli).
- **Withdrawal Flow**: Seller dapat melakukan *request withdrawal* (Penarikan Dana) di *dashboard* toko mereka dengan menginputkan nomor rekening bank.
- Superadmin bertugas memproses *withdrawal* tersebut (bisa manual, atau diintegrasikan ke API *Payout* Xendit).

### 3. Laporan & Statistik Penjualan (Analytics)
- Tambahkan halaman analitik di *Dashboard Seller*.
- Gunakan *library* pihak ketiga yang elegan, seperti **Chart.js** atau **ApexCharts**.
- Tampilkan:
  - Grafik garis (Line Chart) pendapatan harian/bulanan.
  - Grafik batang (Bar Chart) jumlah produk yang paling sering dibeli.

## 📝 Catatan Khusus untuk AI Selanjutnya
- Tolong baca struktur database di `docs/DATABASE_SCHEMA.md` sebelum mulai membuat migrasi baru untuk *Wallet* atau *Withdrawal*.
- Selalu pertahankan desain estetika tingkat tinggi! Tema *premium dark mode* harus diwariskan ke halaman Admin dan Dashboard Seller.
- Fokus pada efisiensi *tool* (gunakan `grep_search`, hindari *command bash* standar jika ada API tool bawaan).

*Selamat bekerja! MineCart siap menjadi E-Commerce impian!*
