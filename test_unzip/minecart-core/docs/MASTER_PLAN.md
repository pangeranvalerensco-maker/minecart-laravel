# 🚀 Master Plan Pengembangan MineCart E-Commerce

Dokumen ini berisi peta jalan (roadmap) pengembangan website e-commerce MineCart secara komprehensif dari segala sisi, mulai dari fitur dasar hingga fitur level *enterprise*. Dokumen ini ditujukan sebagai panduan untuk pengembangan di sesi-sesi berikutnya.

---

## 🗺️ Roadmap Fitur E-Commerce

### ✅ Fase 1: Fondasi & Inti (Telah Diselesaikan)
- Autentikasi Pengguna (Register, Login).
- Pemisahan Peran (Pembeli & Penjual).
- Manajemen Produk (CRUD).
- Keranjang Belanja (Cart) & Checkout.
- Payment Gateway Integrasi (Midtrans) & COD.
- Login via Google (SSO) & Lupa Password OTP.

### ✅ Fase 2: Interaksi & Transaksi Lanjutan (Telah Diselesaikan)
1. **Sistem Ulasan (Review & Rating)**
   - Pembeli dapat memberikan bintang (1-5) dan komentar beserta foto setelah pesanan berstatus "Selesai".
   - Menampilkan rata-rata rating di halaman beranda dan detail produk.
2. **Integrasi Ekspedisi / Kurir (RajaOngkir API)**
   - Saat *checkout*, pembeli bisa memilih kurir (JNE, TIKI, POS, J&T, dll).
   - Menghitung ongkos kirim otomatis berdasarkan berat produk (gram) dan kota tujuan.
3. **Sistem Lacak Resi (Tracking)**
   - Penjual dapat memasukkan nomor resi pengiriman.
   - Pembeli dapat melacak status resi langsung dari dalam aplikasi.
4. **Sistem Chat Real-time (Penjual ↔ Pembeli)**
   - Fitur *Live Chat* menggunakan WebSocket (Pusher/Laravel WebSockets) / Polling AJAX agar pembeli bisa bertanya langsung ke penjual.
5. **Sistem Pembayaran Manual (Sementara)**
   - Menambahkan opsi Transfer Bank Manual dengan fitur upload bukti pembayaran untuk menggantikan Midtrans sementara.

### ✅ Fase 3: Promosi, Retensi, & Re-Integrasi (Telah Diselesaikan)
1. **Mesin Flash Sale**
   - Modul diskon yang dibatasi waktu (Countdown Timer).
   - Membatasi jumlah stok promo per pengguna.
2. **Kupon & Voucher Diskon**
   - Kode promo gratis ongkir atau diskon persentase.
3. **Wishlist (Daftar Keinginan)**
   - Fitur menyimpan produk favorit untuk dibeli nanti.
4. **Integrasi Payment Gateway (Xendit)**
   - Menggantikan Midtrans dengan Xendit Invoice untuk pembayaran otomatis yang lebih mudah.

### ✅ Fase 4: Administratif & Analytics (Telah Diselesaikan)
1. **Superadmin Dashboard**
   - Halaman khusus admin utama (pemilik platform) untuk memantau total transaksi, memblokir toko nakal, dan mengelola komisi.
2. **Sistem Penarikan Dana (Withdrawal/Payout)**
   - Uang dari pembeli masuk ke sistem (Escrow), dan baru diteruskan ke saldo penjual jika barang sudah diterima.
   - Penjual bisa menarik saldo ke rekening bank asli mereka.
3. **Laporan & Statistik Penjualan (Chart)**
   - Grafik penjualan per bulan untuk penjual menggunakan *Chart.js*.

---

## 🛠️ Panduan Setup Fitur Nyata (Production-Ready)

Karena proyek ini akan dijalankan sebagai aplikasi nyata, Anda wajib mengatur konfigurasi layanan pihak ketiga secara riil.

### 1. Setup Email SMTP (Untuk Kirim OTP Sungguhan via Gmail)
Agar email OTP benar-benar masuk ke email Anda/pengguna, ikuti langkah ini:
1. Buka Akun Google Anda -> Keamanan (Security) -> Aktifkan **Verifikasi 2 Langkah**.
2. Masuk ke **Sandi Aplikasi (App Passwords)**.
3. Buat sandi aplikasi baru dengan nama "MineCart Web". Anda akan mendapat 16 digit password khusus.
4. Buka file `.env` di proyek ini, dan ubah bagian `MAIL_` menjadi:
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=465
   MAIL_USERNAME=email_anda@gmail.com
   MAIL_PASSWORD=16_digit_sandi_aplikasi_disini_tanpa_spasi
   MAIL_ENCRYPTION=ssl
   MAIL_FROM_ADDRESS=email_anda@gmail.com
   MAIL_FROM_NAME="${APP_NAME}"
   ```
5. *Clear cache*: jalankan perintah `php artisan config:clear`. Sekarang OTP akan benar-benar dikirim ke email!

### 2. Setup Login Google (SSO)
1. Buka [Google Cloud Console](https://console.cloud.google.com/).
2. Buat **New Project** bernama "MineCart".
3. Ke menu **APIs & Services** -> **Credentials**.
4. Klik **Create Credentials** -> **OAuth client ID**.
5. Pilih *Application Type*: **Web application**.
6. Pada bagian **Authorized redirect URIs**, tambahkan: `http://localhost:8000/auth/google/callback`
7. Simpan, lalu Anda akan mendapatkan *Client ID* dan *Client Secret*.
8. Buka `.env` Anda dan tambahkan di baris paling bawah:
   ```env
   GOOGLE_CLIENT_ID=masukkan_client_id_dari_google_disini
   GOOGLE_CLIENT_SECRET=masukkan_client_secret_dari_google_disini
   GOOGLE_REDIRECT_URI="http://localhost:8000/auth/google/callback"
   ```

### 3. Setup Midtrans
Pastikan Anda mendaftar di [Midtrans Dashboard](https://dashboard.midtrans.com/):
1. Masuk ke environment **Sandbox** (Untuk testing).
2. Ke menu **Settings -> Access Keys**.
3. *Copy* Merchant ID, Client Key, dan Server Key Anda.
4. Paste ke `.env`:
   ```env
   MIDTRANS_MERCHANT_ID=G-xxxx
   MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxx
   MIDTRANS_SERVER_KEY=SB-Mid-server-xxxx
   MIDTRANS_IS_PRODUCTION=false
   ```

---
*Catatan untuk AI Assistant (Sesi Berikutnya): Baca file ini sebagai panduan konteks jika user meminta untuk melanjutkan pengerjaan proyek MineCart E-commerce.*
