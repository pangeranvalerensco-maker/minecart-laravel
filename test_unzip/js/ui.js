// =================================================================================
// == MineCart UI Script (Sprint 1)
// =================================================================================

const translations = {
    id: {
        'page-title-home': 'MineCart - Beranda',
        'page-title-products': 'MineCart - Semua Produk',
        'hero-title': 'Koleksi Terbaru Musim Ini',
        'hero-subtitle': 'Temukan gaya terbaik Anda dengan produk pilihan berkualitas tinggi.',
        'hero-cta': 'Lihat Semua Produk',
        'featured-title': 'Produk Rekomendasi',
        'related-products-title': 'Mungkin Anda Suka',
        'recommended-title': 'Rekomendasi',
        'see-more-btn': 'Lihat Lainnya',
        'buy-button': 'Tambah ke Keranjang',
        'loading-text': 'Memuat produk...',
        'page-title': 'Toko Keren',
        'follow-us-title': 'Ikuti Kami di',
        'contact-location-detail': 'Bandung, Jawa Barat',
        'help-title': 'Bantuan',
        'page-title-about': 'MineCart - Tentang Kami',
        'login': 'Masuk',
        'register': 'Daftar',
        'search-title': 'Cari di MineCart...',
        'categories-title': 'Kategori',

        'cart-title': 'Keranjang Belanja',
        'home-title': 'Beranda',
        'all-products-title': 'Semua Produk',
        'page-title-help': 'MineCart - Bantuan',
        'page-title-cart': 'MineCart - Keranjang Belanja',
        'page-title-login': 'MineCart - Masuk',
        'page-title-register': 'MineCart - Daftar',
        'register-header': 'Buat Akun Baru',
        'search-btn-title': 'Cari',
        'cart-link-title': 'Lihat Keranjang Belanja',
        'theme-toggle-title': 'Ubah Tema',
        'loading-product': 'Memuat...',
        'loading-description': 'Deskripsi produk sedang dimuat...',
        'loading-stock': 'Stok: -',
        'error-load-products': 'Gagal memuat produk. Silakan coba lagi nanti.',
        'page-title-search': 'Hasil untuk',
        'search-results-for': 'Hasil Pencarian untuk',
        'no-search-results': 'Tidak ada produk yang cocok dengan pencarian',
        'my-account': 'Akun Saya',
        'logout': 'Keluar',
        'btn-saving': 'Menyimpan...',
        'select-lang': 'Ganti Bahasa',
        'search-btn': 'Cari',
        'theme-toggle-btn': 'Ubah Tema',
        'cart-empty-message': 'Keranjang Anda kosong.',
        'cart-empty-title': 'Keranjang Belanja Kosong',
        'cart-empty-desc': 'Anda belum menambahkan produk apa pun ke keranjang belanja.',
        'order-history': 'Riwayat Pesanan',
        'seller-analytics': 'Analitik Penjualan',
        'seller-wallet': 'Dompet & Penarikan',
        'seller-orders': 'Pesanan Masuk',
        'seller-products': 'Produk Saya',
        'categories': {
            'Semua': 'Semua',
            'Pakaian': 'Pakaian',
            'Elektronik': 'Elektronik',
            'Aksesoris': 'Aksesoris',
            'Buku': 'Buku',
            'Kecantikan': 'Kecantikan',
            'Olahraga': 'Olahraga',
            'Rumah & Dapur': 'Rumah & Dapur'
        },
        'sort-title': 'Urutkan Berdasarkan: ',
        'sort-price-asc': 'Harga: Terendah ke Tertinggi',
        'sort-price-desc': 'Harga: Tertinggi ke Terendah',
        'sort-name-asc': 'Nama: A-Z',
        'sort-name-desc': 'Nama: Z-A',
        'sort-stock-desc': 'Stok: Terbanyak',
        'sort-stock-asc': 'Stok: Paling Sedikit',
        'sort-location-asc': 'Lokasi: Terdekat',
        'sort-location-desc': 'Lokasi: Terjauh',
        'summary-title': 'Ringkasan Belanja',
        'summary-subtotal': 'Subtotal',
        'summary-total': 'Total',
        'remove-item': 'Hapus',
        'product-location-title': 'Lokasi Produk:',
        'not-available': 'Tidak tersedia',
        'help-q1': 'Bagaimana cara memesan produk?',
        'help-a1': 'Anda dapat memesan produk dengan menekan tombol "Tambah ke Keranjang", lalu melanjutkan ke halaman keranjang untuk menyelesaikan proses checkout.',
        'help-q2': 'Apa saja metode pembayaran yang diterima?',
        'help-a2': 'Saat ini, proyek ini adalah simulasi front-end dan tidak memproses pembayaran sungguhan. Semua fitur checkout hanya untuk tujuan demonstrasi.',
        'help-q3': 'Berapa lama waktu pengiriman?',
        'help-a3': 'Karena ini adalah website simulasi, tidak ada pengiriman fisik yang terjadi. Namun, kami memastikan pengalaman berbelanja virtual Anda secepat mungkin!',
        'help-q4': 'Bagaimana cara mengembalikan produk?',
        'help-a4': 'Proses pengembalian produk saat ini tidak dapat dilakukan karena website ini merupakan simulasi untuk proyek. Namun, kami selalu memastikan data produk yang ditampilkan akurat.',
        'help-q5': 'Apakah semua produk ready stock?',
        'help-a5': 'Ya, semua produk yang ditampilkan di website ini dianggap ready stock. Jumlah stok yang tertera pada setiap halaman produk adalah angka simulasi dan akan berkurang setiap kali ada transaksi pembelian.',
        'help-q6': 'Bagaimana cara mengubah data akun saya?',
        'help-a6': 'Fitur untuk mengubah data akun seperti password atau alamat akan tersedia di halaman "Akun Saya" yang saat ini sedang dalam pengembangan untuk proyek ini.',
        'help-q7': 'Ke mana saja jangkauan pengiriman MineCart?',
        'help-a7': 'Jangkauan pengiriman kami seluas imajinasi Anda! Sebagai platform simulasi, kami dapat "mengirim" ke lokasi mana pun di dunia virtual. Tidak ada biaya ongkos kirim yang akan dikenakan.',
        'help-q8': 'Bagaimana jika saya butuh bantuan lebih lanjut?',
        'help-a8': 'Jika pertanyaan Anda tidak terjawab di sini, jangan ragu untuk mengunjungi halaman "Tentang Kami" untuk mempelajari lebih lanjut tentang proyek ini atau hubungi kami melalui media sosial yang tertera di bagian atas halaman.',
        'help-q9': 'Mengapa ada fitur tema gelap/terang?',
        'help-a9': 'Kami menyediakan fitur tema gelap dan terang untuk memberikan kenyamanan visual maksimal bagi Anda. Fitur ini dibuat menggunakan CSS Variables dan JavaScript untuk menunjukkan salah satu komponen wajib dalam proyek ini.',
        'help-q-order-flow': 'Bagaimana alur pemesanan di MineCart?',
        'help-a-order-flow-step1': 'Pilih produk yang Anda inginkan dan klik tombol "Tambah ke Keranjang".',
        'help-a-order-flow-step2': 'Setelah selesai, masuk ke halaman Keranjang Belanja melalui ikon di kanan atas.',
        'help-a-order-flow-step3': 'Periksa kembali item Anda, lalu klik tombol "Checkout".',
        'help-a-order-flow-step4': 'Isi informasi pengiriman dan selesaikan pembayaran.',
        'help-q-video': 'Apakah ada video perkenalan MineCart?',
        'help-q-audio': 'Apakah MineCart memiliki jingle?',
        'help-q-features': 'Apa saja fitur utama di website ini?',
        'help-a-features-1': 'Pencarian Produk: Pengguna dapat mencari produk berdasarkan nama, kategori, atau deskripsi.',
        'help-a-features-2': 'Keranjang Belanja Dinamis: Keranjang belanja yang terpisah untuk setiap pengguna, disimpan di Local Storage.',
        'help-a-features-3': 'Checkout & Simulasi Stok: Alur checkout lengkap dengan simulasi pengurangan stok produk.',
        'help-a-features-4': 'Tema Gelap & Terang: Pengguna dapat mengganti tema website untuk kenyamanan visual.',
        'help-a-features-5': 'Multi-Bahasa: Website mendukung dua bahasa (Indonesia & Inggris) yang dapat diganti.',
        'help-q-tags': 'Elemen HTML5 apa saja yang digunakan di proyek ini?',
        'help-a-tags-1': 'Struktur Semantik: Penggunaan <header>, <main>, <footer>, <nav>, <section>, dan <article> untuk membangun layout yang bermakna.',
        'help-a-tags-2': 'Multimedia: Implementasi <video> dan <audio> di halaman Bantuan, serta <figure> dan <figcaption> untuk gambar dengan keterangan.',
        'help-a-tags-3': 'Daftar: Penggunaan <ul> untuk daftar tidak berurutan dan <ol> untuk daftar langkah-langkah yang berurutan.',
        'help-a-tags-4': 'Formulir Interaktif: Penggunaan <form>, <input> dengan berbagai tipe, dan <details> & <summary> untuk FAQ accordion.',
        'login-title': 'Masuk ke Akun Anda',
        'register-title': 'Daftar Akun Baru',
        'label-username': 'Nama Pengguna',
        'label-email': 'Email',
        'label-password': 'Kata Sandi',
        'label-dob': 'Tanggal Lahir',
        'label-gender': 'Jenis Kelamin',
        'gender-male': 'Pria',
        'gender-female': 'Wanita',
        'btn-login': 'Masuk',
        'btn-register': 'Daftar',
        'auth-switch-text-login': 'Sudah punya akun? ',
        'auth-switch-link-login': 'Masuk di sini',
        'auth-switch-text-register': 'Belum punya akun? ',
        'auth-switch-link-register': 'Daftar di sini',
        'toast-add-success': 'Produk berhasil ditambahkan ke keranjang!',
        'toast-register-success': 'Pendaftaran berhasil! Silakan masuk.',
        'toast-login-success': 'Selamat datang, {{username}}!',
        'toast-login-error': 'Nama pengguna atau password salah!',
        'toast-fill-all-fields': 'Semua field wajib diisi!',
        'toast-account-not-found': 'Akun tidak ditemukan. Silakan daftar.',
        'validation-required': 'Kolom ini wajib diisi.',
        'validation-password-short': 'Password minimal 6 karakter.',
        'toast-email-exists': 'Email ini sudah terdaftar. Silakan gunakan email lain.',
        'toast-must-login': 'Anda harus masuk untuk menambahkan barang!',
        'select-all': 'Pilih Semua',
        'summary-title': 'Ringkasan Belanja',
        'summary-subtotal': 'Subtotal',
        'summary-shipping': 'Ongkir',
        'summary-total': 'Total',
        'summary-checkout-btn': 'Checkout',
        'summary-empty-cart': 'Pilih barang untuk dihitung.',
        'summary-items': 'barang',
        'cart-must-login': 'Anda harus masuk untuk melihat keranjang.',
        'toast-remove-item': 'Produk berhasil dihapus dari keranjang.',
        'empty-cart-message': 'Keranjang Anda kosong.',
        'view-cart-btn': 'Lihat Keranjang',
        'page-title-account': 'MineCart - Akun Saya',
        'account-info': 'Informasi Akun',
        'address-info': 'Informasi Alamat',
        'label-fullname': 'Nama Lengkap',
        'label-address': 'Alamat Lengkap',
        'label-city': 'Kota',
        'label-postalcode': 'Kode Pos',
        'label-phone': 'Nomor Telepon',
        'edit-address-btn': 'Edit Alamat',
        'edit-address-title': 'Edit Alamat',
        'save-address-btn': 'Simpan Alamat',
        'cancel-btn': 'Batal',
        'toast-address-saved': 'Alamat berhasil disimpan!',
        'toast-address-error': 'Gagal menyimpan alamat. Mohon isi semua field.',
        'not-filled': 'Belum diisi',
        'shipping-address-missing': 'Silakan lengkapi alamat di halaman akun untuk menghitung ongkir.',
        'page-title-checkout': 'MineCart - Checkout',
        'cart-quantity': 'Jumlah:',
        'checkout-title': 'Checkout Pesanan',
        'order-summary-title': 'Ringkasan Belanja Anda',
        'shipping-info-title': 'Informasi Pengiriman',
        'change-address-btn': 'Ubah Alamat',
        'payment-method-title': 'Metode Pembayaran',
        'courier-note-title': 'Catatan untuk Kurir (Opsional)',
        'courier-note-label': 'Catatan untuk Kurir',
        'courier-note-placeholder': 'Contoh: Titip ke satpam jika tidak ada orang di rumah.',
        'place-order-btn': 'Selesaikan Pembayaran',
        'toast-checkout-no-items': 'Pilih setidaknya satu barang untuk checkout.',
        'review-page-title': 'Beri Ulasan Produk',
        'review-order-label': 'Pesanan: #',
        'review-rating-label': 'Penilaian Anda (Bintang)',
        'review-comment-label': 'Komentar (Opsional)',
        'review-comment-placeholder': 'Bagaimana kualitas produk ini?',
        'review-photo-label': 'Foto Produk (Opsional)',
        'review-cancel-btn': 'Batal',
        'review-submit-btn': 'Kirim Ulasan',
        'toast-checkout-no-address': 'Alamat pengiriman belum lengkap. Mohon lengkapi di halaman akun.',
        'toast-checkout-data-missing': 'Data pesanan tidak ditemukan. Kembali ke keranjang.',
        'toast-no-payment-method': 'Silakan pilih metode pembayaran.',
        'toast-order-success': 'Pesanan berhasil diproses! Terima kasih.',
        'toast-stock-issue': 'Gagal memproses pesanan: Stok produk tidak mencukupi.',
        'toast-sort-location-error': 'Untuk mengurutkan berdasarkan lokasi, Anda harus masuk & melengkapi alamat.',
        'summary-subtotal': 'Subtotal',
        'summary-shipping': 'Ongkir',
        'summary-items': 'barang',
        'summary-total': 'Total',
        'shipping-time-label': 'Estimasi Waktu Sampai:',
        'shipping-time-days': 'hari',
        'product-seller-title': 'Penjual:',
        'seller-name-label': 'Nama Toko:',
        'cs-title': 'Selamat Datang!!',
        'cs-welcome': 'Selamat datang di MineCart Web! Temukan berbagai produk berkualitas tinggi dengan harga terbaik.',
        'footer-title': '© 2025 MineCart. Dibuat oleh Pangeran Valerensco Rivaldi Hutabarat. Semua hak cipta dilindungi.',
        'open-store': 'Buka Toko',
        'my-store': 'Toko Saya',
        'my-profile': 'Profil Saya',
        'filter-category': 'Kategori',
        'filter-price': 'Harga',
        'min-price': 'Harga Minimum',
        'max-price': 'Harga Maksimum',
        'apply-price': 'Terapkan Harga',
        'order-subtotal': 'Subtotal',
        'order-shipping': 'Biaya Pengiriman',
        'order-grand-total': 'Total Pembayaran',
        'see-details': 'Lihat Detail',
        'checkout-shipping': 'Pengiriman',
        'checkout-payment': 'Metode Pembayaran',
        'checkout-pay': 'Selesaikan Pembayaran',
        'success-order-created': 'Pesanan Dibuat!',
        'success-thank-you': 'Terima kasih telah berbelanja di MineCart.',
        'success-order-number': 'Nomor Pesanan Anda:',
        'success-cod-msg': 'Pembayaran akan dilakukan di tempat (COD) saat barang sampai.',
        'success-paid': 'Pembayaran telah berhasil diterima!',
        'success-waiting': 'Menunggu konfirmasi pembayaran dari Xendit.',
        'success-click-pay': 'Klik di sini jika Anda belum menyelesaikan pembayaran.',
        'success-back-home': 'Kembali Berbelanja',
        'cart-clear-btn': 'Kosongkan Keranjang',
        'summary-total-price': 'Total Harga (',
        'summary-items': 'Barang)',
        'summary-total': 'Total',
        'checkout-btn-text': 'Beli'
    },
    en: {
        'page-title-home': 'MineCart - Homepage',
        'page-title-products': 'MineCart - All Products',
        'hero-title': 'This Season\'s Newest Collection',
        'hero-subtitle': 'Find your best style with high-quality selected products.',
        'hero-cta': 'Shop All Products',
        'featured-title': 'Recommended Products',
        'related-products-title': 'You Might Also Like',
        'recommended-title': 'Recommended',
        'see-more-btn': 'See More',
        'buy-button': 'Add to Cart',
        'loading-text': 'Loading products...',
        'page-title': 'Cool Store',
        'follow-us-title': 'Follow Us On',
        'about-us-title': 'About Us',
        'about-welcome-title': 'Welcome to MineCart!',
        'about-p1': 'MineCart was born from our love for the MineCraft world and a desire to provide quality products for gamers and pop culture fans. We believe everyone has the right to express their style, and we are here to help make that a reality.',
        'about-mission-title': 'Our Mission',
        'about-p2': 'Our mission is to be your ultimate "treasure chest" for all modern lifestyle needs. We carefully select each item, ensuring you get the best products that are unique and full of character. Happy Browse and "Craft Your Style!"',
        'about-hq-title': 'MineCart HQ',
        'dev-name': 'Created by: Pangeran Valerensco Rivaldi Hutabarat',
        'dev-bio': 'I am an Informatics Engineering student passionate about web development and software engineering. I built this MineCart project as a portfolio to showcase my abilities in designing modern e-commerce applications using Laravel, ranging from database management and payment system integration to dynamic interface design.',
        'help-title': 'Help',
        'contact-title': 'Contact Us',
        'contact-email-title': 'Email',
        'contact-phone-title': 'Phone',
        'contact-location-title': 'Location',
        'contact-location-detail': 'Bandung, West Java',
        'contact-social-title': 'Social Media',
        'page-title-about': 'MineCart - About Us',
        'page-title-cart': 'MineCart - Shopping Cart',
        'page-title-login': 'MineCart - Login',
        'login-header': 'login to your account',
        'page-title-register': 'MineCart - Register',
        'register-header': 'Create a New Account',
        'login': 'Login',
        'register': 'Register',
        'search-title': 'Search in MineCart...',
        'categories-title': 'Categories',
        'order-history': 'Order History',
        'seller-analytics': 'Sales Analytics',
        'seller-wallet': 'Wallet & Withdrawals',
        'seller-orders': 'Incoming Orders',
        'seller-products': 'My Products',
        'empty-order-history': 'You have never shopped before.',
        'order-history-title': 'Your Order History',
        'order-number': 'Order #',
        'cart-title': 'Shopping Cart',
        'home-title': 'Home Page',
        'all-products-title': 'All Products',
        'page-title-help': 'MineCart - Help',
        'search-btn-title': 'Search',
        'cart-link-title': 'View Shopping Cart',
        'theme-toggle-title': 'Change Theme',
        'loading-product': 'Loading...',
        'loading-description': 'Product description is loading...',
        'loading-stock': 'Stock: -',
        'error-load-products': 'Failed to load products. Please try again later.',
        'page-title-search': 'Results for',
        'search-results-for': 'Search Results for',
        'no-search-results': 'No products found matching the search',
        'my-account': 'My Account',
        'logout': 'Logout',
        'btn-saving': 'Saving...',
        'select-lang': 'Change Language',
        'search-btn': 'Search',
        'theme-toggle-btn': 'Change Theme',
        'categories': {
            'Semua': 'All',
            'Pakaian': 'Apparel',
            'Elektronik': 'Electronics',
            'Aksesoris': 'Accessories',
            'Buku': 'Books',
            'Kecantikan': 'Beauty',
            'Olahraga': 'Sports',
            'Rumah & Dapur': 'Home & Kitchen'
        },
        'sort-title': 'Sort By: ',
        'sort-price-asc': 'Price: Low to High',
        'sort-price-desc': 'Price: High to Low',
        'sort-name-asc': 'Name: A-Z',
        'sort-name-desc': 'Name: Z-A',
        'sort-stock-desc': 'Stock: Highest',
        'sort-stock-asc': 'Stock: Lowest',
        'sort-location-asc': 'Location: Nearest',
        'sort-location-desc': 'Location: Farthest',
        'summary-title': 'Order Summary',
        'summary-subtotal': 'Subtotal',
        'summary-total': 'Total',
        'remove-item': 'Remove',
        'product-location-title': 'Product Location:',
        'not-available': 'Not available',
        'help-q1': 'How do I order a product?',
        'help-a1': 'You can order a product by pressing the "Add to Cart" button, then proceed to the cart page to complete the checkout process.',
        'help-q2': 'What payment methods are accepted?',
        'help-a2': 'Currently, this project is a front-end simulation and does not process real payments. All checkout features are for demonstration purposes only.',
        'help-q3': 'How long is the shipping time?',
        'help-a3': 'Since this is a simulation website, no physical shipping occurs. However, we ensure your virtual shopping experience is as fast as possible!',
        'help-q4': 'How do I return a product?',
        'help-a4': 'The product return process is currently unavailable as this website is a project simulation. However, we always ensure the product data displayed is accurate.',
        'help-q5': 'Are all products ready stock?',
        'help-a5': 'Yes, all products displayed on this website are considered ready stock. The stock quantity shown on each product page is a simulation number and will decrease with each purchase transaction.',
        'help-q6': 'How do I change my account details?',
        'help-a6': 'Features to change account details like password or address will be available on the "My Account" page, which is currently under development for this project.',
        'help-q7': 'What is the shipping range of MineCart?',
        'help-a7': 'Our shipping range is as vast as your imagination! As a simulation platform, we can "ship" to any location in the virtual world. No shipping fees will be charged.',
        'help-q8': 'What if I need further assistance?',
        'help-a8': 'If your question is not answered here, feel free to visit the "About Us" page to learn more about this project or contact us via the social media listed at the top of the page.',
        'help-q9': 'Why is there a dark/light theme feature?',
        'help-a9': 'We provide a dark and light theme feature to offer maximum visual comfort for you. This feature is built using CSS Variables and JavaScript to demonstrate one of the mandatory components of this project.',
        'help-q-order-flow': 'What is the order flow on MineCart?',
        'help-a-order-flow-step1': 'Select the product you want and click the "Add to Cart" button.',
        'help-a-order-flow-step2': 'When finished, go to the Shopping Cart page via the icon in the top right.',
        'help-a-order-flow-step3': 'Review your items, then click the "Checkout" button.',
        'help-a-order-flow-step4': 'Fill in the shipping information and complete the payment.',
        'help-q-video': 'Is there a MineCart introduction video?',
        'help-q-audio': 'Does MineCart have a jingle?',
        'help-q-features': 'What are the main features of this website?',
        'help-a-features-1': 'Product Search: Users can search for products by name, category, or description.',
        'help-a-features-2': 'Dynamic Shopping Cart: A separate shopping cart for each user, stored in Local Storage.',
        'help-a-features-3': 'Checkout & Stock Simulation: A complete checkout flow with product stock reduction simulation.',
        'help-a-features-4': 'Dark & Light Theme: Users can switch the website theme for visual comfort.',
        'help-a-features-5': 'Multi-Language: The website supports two languages (Indonesian & English) that can be switched.',
        'help-q-tags': 'What HTML5 elements are used in this project?',
        'help-a-tags-1': 'Semantic Structure: Use of <header>, <main>, <footer>, <nav>, <section>, and <article> to build a meaningful layout.',
        'help-a-tags-2': 'Multimedia: Implementation of <video> and <audio> on the Help page, as well as <figure> and <figcaption> for images with captions.',
        'help-a-tags-3': 'Lists: Use of <ul> for unordered lists and <ol> for ordered step-by-step lists.',
        'help-a-tags-4': 'Interactive Forms: Use of <form>, <input> with various types, and <details> & <summary> for the FAQ accordion.',
        'login-title': 'Login to Your Account',
        'register-title': 'Create a New Account',
        'label-username': 'Username',
        'label-email': 'Email',
        'label-password': 'Password',
        'label-dob': 'Date of Birth',
        'label-gender': 'Gender',
        'gender-male': 'Male',
        'gender-female': 'Female',
        'btn-login': 'Login',
        'btn-register': 'Register',
        'auth-switch-text-login': 'Already have an account? ',
        'auth-switch-link-login': 'Login here',
        'auth-switch-text-register': 'Don\'t have an account? ',
        'auth-switch-link-register': 'Register here',
        'toast-add-success': 'Product added to cart successfully!',
        'toast-register-success': 'Registration successful! Please login.',
        'toast-login-success': 'Welcome, {{username}}!',
        'toast-login-error': 'Incorrect username or password!',
        'toast-fill-all-fields': 'All fields are required!',
        'toast-account-not-found': 'Account not found. Please register.',
        'validation-required': 'This field is required.',
        'validation-password-short': 'Password must be at least 6 characters.',
        'toast-email-exists': 'This email is already registered. Please use another email.',
        'toast-must-login': 'You must be logged in to add items!',
        'select-all': 'Select All',
        'summary-title': 'Order Summary',
        'summary-subtotal': 'Subtotal',
        'summary-shipping': 'Shipping',
        'summary-total': 'Total',
        'summary-checkout-btn': 'Checkout',
        'summary-empty-cart': 'Select items to calculate.',
        'summary-items': 'items',
        'cart-must-login': 'You must be logged in to view the cart.',
        'toast-remove-item': 'Product successfully removed from cart.',
        'empty-cart-message': 'Your cart is empty.',
        'cart-empty-message': 'Your cart is empty.',
        'cart-empty-title': 'Shopping Cart is Empty',
        'cart-empty-desc': 'You have not added any products to your shopping cart yet.',
        'view-cart-btn': 'View Cart',
        'page-title-account': 'MineCart - My Account',
        'account-info': 'Account Information',
        'address-info': 'Address Information',
        'label-fullname': 'Full Name',
        'label-address': 'Full Address',
        'label-city': 'City',
        'label-postalcode': 'Postal Code',
        'label-phone': 'Phone Number',
        'edit-address-btn': 'Edit Address',
        'edit-address-title': 'Edit Address',
        'save-address-btn': 'Save Address',
        'cancel-btn': 'Cancel',
        'toast-address-saved': 'Address saved successfully!',
        'toast-address-error': 'Failed to save address. Please fill all fields.',
        'not-filled': 'Not Filled',
        'shipping-address-missing': 'Please complete your address in the account page to calculate shipping.',
        'page-title-checkout': 'MineCart - Checkout',
        'cart-quantity': 'Quantity:',
        'checkout-title': 'Order Checkout',
        'order-summary-title': 'Your Order Summary',
        'shipping-info-title': 'Shipping Information',
        'change-address-btn': 'Change Address',
        'payment-method-title': 'Payment Method',
        'courier-note-title': 'Note for Courier (Optional)',
        'courier-note-label': 'Note for Courier',
        'courier-note-placeholder': 'Example: Leave with security if no one is home.',
        'place-order-btn': 'Complete Payment',
        'toast-checkout-no-items': 'Please select at least one item to checkout.',
        'review-page-title': 'Write a Product Review',
        'review-order-label': 'Order: #',
        'review-rating-label': 'Your Rating (Stars)',
        'review-comment-label': 'Comment (Optional)',
        'review-comment-placeholder': 'How is the quality of this product?',
        'review-photo-label': 'Product Photo (Optional)',
        'review-cancel-btn': 'Cancel',
        'review-submit-btn': 'Submit Review',
        'toast-checkout-no-address': 'Shipping address is incomplete. Please complete it in your account page.',
        'toast-checkout-data-missing': 'Order data not found. Returning to cart.',
        'toast-no-payment-method': 'Please select a payment method.',
        'toast-order-success': 'Order processed successfully! Thank you.',
        'toast-stock-issue': 'Failed to process order: Insufficient product stock.',
        'toast-sort-location-error': 'To sort by location, you must be logged in & have a complete address.',
        'summary-subtotal': 'Subtotal',
        'summary-shipping': 'Shipping',
        'summary-items': 'items',
        'summary-total': 'Total',
        'shipping-time-label': 'Estimated Delivery Time:',
        'shipping-time-days': 'days',
        'product-seller-title': 'Seller:',
        'seller-name-label': 'Store Name:',
        'cs-title': 'Welcome!!',
        'cs-welcome': 'Welcome to MineCart Web! Discover a wide range of high-quality products at the best prices.',
        'footer-title': '© 2025 MineCart. Created by Pangeran Valerensco Rivaldi Hutabarat. All rights reserved.',
        'open-store': 'Open Store',
        'my-store': 'My Store',
        'my-profile': 'My Profile',
        'filter-category': 'Category',
        'filter-price': 'Price',
        'min-price': 'Min Price',
        'max-price': 'Max Price',
        'apply-price': 'Apply Price',
        'order-subtotal': 'Subtotal',
        'order-shipping': 'Shipping Cost',
        'order-grand-total': 'Grand Total',
        'see-details': 'View Details',
        'checkout-shipping': 'Shipping',
        'checkout-payment': 'Payment Method',
        'checkout-pay': 'Complete Payment',
        'success-order-created': 'Order Created!',
        'success-thank-you': 'Thank you for shopping at MineCart.',
        'success-order-number': 'Your Order Number:',
        'success-cod-msg': 'Payment will be made on delivery (COD).',
        'success-paid': 'Payment received successfully!',
        'success-waiting': 'Waiting for payment confirmation from Xendit.',
        'success-click-pay': 'Click here if you haven\'t completed the payment.',
        'success-back-home': 'Back to Shopping',
        'cart-clear-btn': 'Clear Cart',
        'summary-total-price': 'Total Price (',
        'summary-items': 'Items)',
        'summary-total': 'Total',
        'checkout-btn-text': 'Buy'
    }
};

let currentLang = localStorage.getItem('userLanguage') || 'id';

// --- FUNGSI TEMA ---
function applyTheme(theme) {
    const body = document.body;
    const themeIcon = document.getElementById('theme-icon');
    const cartIcon = document.getElementById('cart-icon-img');
    const sunIconPath = window.minecartAssets?.logoTerang || '/assets/logo-terang.png';
    const moonIconPath = window.minecartAssets?.logoGelap || '/assets/logo-gelap.png';
    const cartLightPath = window.minecartAssets?.cartGelap || '/assets/logo-keranjang-gelap.png';
    const cartDarkPath = window.minecartAssets?.cartTerang || '/assets/logo-keranjang-terang.png';

    if (theme === 'dark') {
        body.classList.add('dark-mode');
        if (themeIcon) themeIcon.src = sunIconPath;
        if (cartIcon) cartIcon.src = cartDarkPath;
    } else {
        body.classList.remove('dark-mode');
        if (cartIcon) cartIcon.src = cartLightPath;
        if (themeIcon) themeIcon.src = moonIconPath;
    }
}

function initializeThemeToggle() {
    const themeToggleBtn = document.getElementById('theme-toggle-btn');
    if (!themeToggleBtn) return;
    
    themeToggleBtn.addEventListener('click', () => {
        const currentTheme = localStorage.getItem('theme') || 'light';
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        localStorage.setItem('theme', newTheme);
        applyTheme(newTheme);
    });
}

// --- FUNGSI CAROUSEL ---
function initializeCarousel() {
    const carouselContainer = document.querySelector('.carousel-container');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const heroSection = document.querySelector('.home-carousel');
    if (!carouselContainer || !prevBtn || !nextBtn || !heroSection) return;

    const slides = document.querySelectorAll('.carousel-slide');
    const slideCount = slides.length;
    let currentIndex = 0;
    let slideInterval;

    function goToSlide(index) {
        carouselContainer.classList.remove('slide-1', 'slide-2', 'slide-3');
        carouselContainer.classList.add(`slide-${index + 1}`);
        currentIndex = index;
    }

    function nextSlide() {
        let nextIndex = (currentIndex + 1) % slideCount;
        goToSlide(nextIndex);
    }
    function prevSlide() {
        let prevIndex = (currentIndex - 1 + slideCount) % slideCount;
        goToSlide(prevIndex);
    }
    function startSlideShow() {
        clearInterval(slideInterval);
        slideInterval = setInterval(nextSlide, 5000);
    }
    function stopSlideShow() {
        clearInterval(slideInterval);
    }
    
    nextBtn.addEventListener('click', () => {
        nextSlide();
        startSlideShow();
    });
    prevBtn.addEventListener('click', () => {
        prevSlide();
        startSlideShow();
    });

    heroSection.addEventListener('mouseenter', stopSlideShow);
    heroSection.addEventListener('mouseleave', startSlideShow);

    goToSlide(0);
    startSlideShow();
}

// --- FUNGSI HAMBURGER ---
function initializeHamburgerMenu() {
    const hamburgerBtn = document.querySelector('.hamburger-btn');
    const mainNav = document.querySelector('.header-main-nav');
    if (hamburgerBtn && mainNav) {
        hamburgerBtn.addEventListener('click', () => {
            mainNav.classList.toggle('is-active');
        });
    }
}

// --- FUNGSI BAHASA ---
function translateUI(lang) {
    document.querySelectorAll('[data-translate-key]').forEach(element => {
        const key = element.getAttribute('data-translate-key');
        if (translations[lang] && translations[lang][key]) {
            const translatedText = translations[lang][key];
            if ((element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') && element.hasAttribute('placeholder')) {
                element.placeholder = translatedText;
            } else if (element.hasAttribute('title')) {
                element.title = translatedText;
            } else {
                element.textContent = translatedText;
            }
        }
    });

    const selectedLangText = document.getElementById('selected-lang-text');
    if (selectedLangText) {
        selectedLangText.textContent = lang === 'en' ? 'English' : 'Bahasa Indonesia';
    }

    const mobileLangLink = document.querySelector('#mobile-lang-switcher a');
    if (mobileLangLink) {
        mobileLangLink.textContent = lang === 'en' ? 'Bahasa Indonesia' : 'English';
    }

    // Terjemahan nama dan deskripsi produk di semua kartu produk dinamis
    document.querySelectorAll('.product-card').forEach(card => {
        const titleEl = card.querySelector('[data-title-id]');
        const descEl = card.querySelector('[data-description-id]');

        if (titleEl && titleEl.dataset.titleId && titleEl.dataset.titleEn) {
            titleEl.textContent = lang === 'id' ? titleEl.dataset.titleId : titleEl.dataset.titleEn;
        }
        if (descEl && descEl.dataset.descriptionId && descEl.dataset.descriptionEn) {
            descEl.textContent = lang === 'id' ? descEl.dataset.descriptionId : descEl.dataset.descriptionEn;
        }
    });

    // Terjemahan produk detail utama
    const detailTitleEl = document.querySelector('.product-detail-info h1[data-title-id]');
    const detailDescEl = document.querySelector('#product-description[data-description-id]');
    if (detailTitleEl && detailTitleEl.dataset.titleId && detailTitleEl.dataset.titleEn) {
        detailTitleEl.textContent = lang === 'id' ? detailTitleEl.dataset.titleId : detailTitleEl.dataset.titleEn;
    }
    if (detailDescEl && detailDescEl.dataset.descriptionId && detailDescEl.dataset.descriptionEn) {
        detailDescEl.textContent = lang === 'id' ? detailDescEl.dataset.descriptionId : detailDescEl.dataset.descriptionEn;
    }

    // Update document.title dynamically
    if (detailTitleEl && detailTitleEl.dataset.titleId && detailTitleEl.dataset.titleEn) {
        document.title = 'MineCart - ' + (lang === 'id' ? detailTitleEl.dataset.titleId : detailTitleEl.dataset.titleEn);
    } else if (document.querySelector('.all-products-page')) {
        document.title = 'MineCart - ' + translations[lang]['all-products-title'];
    } else if (window.location.pathname === '/' || window.location.pathname === '/home') {
        document.title = translations[lang]['page-title-home'] || 'MineCart';
    } else if (window.location.pathname.includes('/about')) {
        document.title = 'MineCart - ' + (translations[lang]['about-us-title'] || 'About Us');
    } else if (window.location.pathname.includes('/help')) {
        document.title = 'MineCart - ' + (translations[lang]['help-title'] || 'Help');
    } else if (window.location.pathname.includes('/cart')) {
        document.title = 'MineCart - ' + (translations[lang]['cart-title'] || 'Cart');
    } else if (window.location.pathname.includes('/account/orders')) {
        document.title = 'MineCart - ' + (translations[lang]['order-history'] || 'Order History');
    } else if (window.location.pathname.includes('/seller/analytics')) {
        document.title = 'MineCart - ' + (translations[lang]['seller-analytics'] || 'Sales Analytics');
    } else if (window.location.pathname.includes('/seller/wallet')) {
        document.title = 'MineCart - ' + (translations[lang]['seller-wallet'] || 'Wallet & Withdrawals');
    } else if (window.location.pathname.includes('/seller/orders')) {
        document.title = 'MineCart - ' + (translations[lang]['seller-orders'] || 'Incoming Orders');
    } else if (window.location.pathname.includes('/seller')) {
        document.title = 'MineCart - ' + (translations[lang]['seller-products'] || 'My Products');
    }

    const cartPreviewTitle = document.getElementById('cart-preview-title');
    if (cartPreviewTitle) {
        const currentText = cartPreviewTitle.textContent;
        const match = currentText.match(/\(\d+\)/);
        const countStr = match ? match[0] : '(0)';
        cartPreviewTitle.textContent = (translations[lang]['cart-title'] || 'Keranjang Belanja') + ' ' + countStr;
    }
}

function initializeLanguageDropdown() {
    const customSelect = document.querySelector('.custom-select');
    if (!customSelect) return;

    const selectButton = customSelect.querySelector('.select-button');
    const dropdown = customSelect.querySelector('.select-dropdown');

    selectButton.addEventListener('click', () => {
        dropdown.classList.toggle('show');
        const isExpanded = dropdown.classList.contains('show');
        selectButton.setAttribute('aria-expanded', isExpanded);
    });

    dropdown.addEventListener('click', (e) => {
        if (e.target.tagName === 'LI') {
            const selectedValue = e.target.dataset.value;
            currentLang = selectedValue;
            localStorage.setItem('userLanguage', currentLang);
            translateUI(currentLang);
            dropdown.classList.remove('show');
            selectButton.setAttribute('aria-expanded', 'false');
        }
    });

    window.addEventListener('click', (e) => {
        if (!customSelect.contains(e.target)) {
            dropdown.classList.remove('show');
            selectButton.setAttribute('aria-expanded', 'false');
        }
    });

    const mobileLangSwitcher = document.getElementById('mobile-lang-switcher');
    if (mobileLangSwitcher) {
        mobileLangSwitcher.addEventListener('click', (e) => {
            e.preventDefault();
            currentLang = currentLang === 'en' ? 'id' : 'en';
            localStorage.setItem('userLanguage', currentLang);
            translateUI(currentLang);
        });
    }
}

// --- FUNGSI CUSTOMER SERVICE POPUP ---
function initializeCSPopup() {
    const popup = document.getElementById('cs-popup');
    if (!popup) return;

    const hasBeenClosed = localStorage.getItem('cs_popup_closed') === 'true';

    if (!hasBeenClosed) {
        popup.classList.remove('hidden-element');
        setTimeout(() => {
            popup.classList.add('is-active');
        }, 2000);
    }

    const closeBtn = popup.querySelector('.close-btn');
    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            popup.classList.remove('is-active');
            localStorage.setItem('cs_popup_closed', 'true');
        });
    }
}

// --- FUNGSI TOAST ---
function showToast(messageKey, type = 'success', data = {}) {
    const toastContainer = document.getElementById('toast-container');
    if (!toastContainer) return;

    let message = translations[currentLang][messageKey] || messageKey;

    for (const key in data) {
        if (data.hasOwnProperty(key)) {
            const placeholder = new RegExp(`{{${key}}}`, 'g');
            message = message.replace(placeholder, data[key]);
        }
    }

    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.textContent = message;

    toastContainer.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3000);
}

// --- INITIALIZATION ---
document.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('theme') || 'light';
    applyTheme(savedTheme);
    translateUI(currentLang);

    initializeCarousel();
    initializeHamburgerMenu();
    initializeThemeToggle();
    initializeLanguageDropdown();
    initializeCSPopup();
});
