<header>
    <!-- Bagian header untuk menampilkan informasi penting di bagian atas halaman -->
    <div class="header-top">
        <div class="container">
            <div class="social-media">
                <span data-translate-key="follow-us-title">Ikuti Kami di</span>
                <a href="https://www.instagram.com/varelrivaldi_hutabarat/" target="_blank"><img
                        src="{{ asset('assets/logo-instagram.webp') }}" alt="Instagram" class="logo-ig" title="Instagram"></a>
                <a href="https://www.facebook.com/varel.rival.9" target="_blank"><img
                        src="{{ asset('assets/logo-facebook.webp') }}" alt="Facebook" class="logo-fb" title="Facebook"></a>
                <a href="https://wa.me/6282181296229" target="_blank"><img
                        src="{{ asset('assets/logo-whatsapp.webp') }}" alt="WhatsApp" class="logo-wa" title="WhatsApp"></a>
                <a href="https://github.com/pangeranvalerensco-maker" target="_blank"><img
                        src="{{ asset('assets/logo-github.jpg') }}" alt="GitHub" class="logo-github" title="GitHub"></a>
            </div>
            <nav class="header-top-nav">
                <ul>
                    <li><a href="#" data-translate-key="about-us-title" class="a-header-top">Tentang Kami</a></li>
                    <li><a href="#" data-translate-key="help-title" class="a-header-top">Bantuan</a></li>
                    <li class="language-selector-wrapper">
                        <!-- Dropdown untuk memilih bahasa -->
                        <div class="custom-select">
                            <button class="select-button" title="Ganti Bahasa" data-translate-key="select-lang">
                                <span id="selected-lang-text">Bahasa Indonesia</span>
                                <span class="arrow-down"></span>
                            </button>
                            <ul class="select-dropdown" role="listbox">
                                <li data-value="id" role="option">Bahasa Indonesia</li>
                                <li data-value="en" role="option">English</li>
                            </ul>
                        </div>
                    </li>
                    <li id="account-menu">
                        <!-- Menu akun simulasi statis (akan diisi oleh JS/Blade jika user login di tahap berikutnya) -->
                        <div class="is-logged-out" id="account-menu-desktop">
                            <a href="#" class="btn btn-secondary" data-translate-key="login">Masuk</a>
                            <a href="#" class="btn btn-primary" data-translate-key="register">Daftar</a>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="header-main">
        <div class="container">
            <div class="header-main-left">
                <a href="{{ route('home') }}" class="logo">
                    <img src="{{ asset('assets/logo-minecart.png') }}" alt="MineCart Logo">
                    <span>MineCart</span>
                </a>
                <button class="hamburger-btn">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
            <form class="search-bar" action="{{ route('products.index') }}" method="GET">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari di MineCart..." data-translate-key="search-title" required>
                <button type="submit" title="Cari" data-translate-key="search-btn"><img src="{{ asset('assets/logo-search.png') }}" alt="Cari"></button>
            </form>

            <nav class="header-main-nav">
                <ul>
                    <!-- Tautan untuk masuk (hanya terlihat di mobile dan saat pengguna belum masuk) -->
                    <li class="mobile-only mobile-only-logged-out"><a href="#" data-translate-key="login">Masuk</a></li>
                    <li class="mobile-only mobile-only-logged-out"><a href="#" data-translate-key="register">Daftar</a></li>

                    <!-- Tautan untuk akun pengguna (hanya terlihat di mobile dan saat pengguna sudah masuk) -->
                    <li class="mobile-only mobile-only-logged-in"><a href="#" data-translate-key="my-account">My Account</a></li>
                    <li class="mobile-only mobile-only-logged-in"><a href="#" id="logout-btn-mobile" data-translate-key="logout">Logout</a></li>

                    <li><a href="{{ route('home') }}#recommended" data-translate-key="recommended-title">Rekomendasi</a></li>
                    <li><a href="{{ route('home') }}" data-translate-key="home-title" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a></li>
                    <li><a href="{{ route('products.index') }}" data-translate-key="all-products-title" class="{{ request()->routeIs('products.index') ? 'active' : '' }}">Semua Produk</a></li>

                    <!-- Tautan untuk halaman tentang dan bantuan (hanya terlihat di mobile) -->
                    <li class="mobile-only"><a href="#" data-translate-key="about-us-title">Tentang Kami</a></li>
                    <li class="mobile-only"><a href="#" data-translate-key="help-title">Bantuan</a></li>

                    <!-- Keranjang belanja -->
                    <li class="cart-icon-wrapper">
                        <a href="#" title="Keranjang Belanja" data-translate-key="cart-link-title">
                            <img src="{{ asset('assets/logo-keranjang-gelap.png') }}" alt="Keranjang" class="icon-nav" id="cart-icon-img">
                            <span id="cart-counter" class="cart-counter visible">0</span>
                            <span class="cart-text-mobile">Keranjang Belanja</span>
                        </a>

                        <div id="cart-preview-dropdown" class="cart-preview">
                            <div class="cart-preview-header">
                                <h4 id="cart-preview-title">Keranjang Belanja (0)</h4>
                                <a href="#" id="cart-preview-view-link" data-translate-key="view-cart-btn">Lihat Keranjang</a>
                            </div>
                            <div id="cart-preview-items">
                                <!-- Tempat untuk menampilkan item di keranjang (kosong untuk sementara) -->
                            </div>
                        </div>
                    </li>
                    <li>
                        <button id="theme-toggle-btn" class="theme-button" title="Ubah Tema" data-translate-key="theme-toggle-title">
                            <img id="theme-icon" src="{{ asset('assets/logo-gelap.png') }}" alt="Tema" data-translate-key="theme-link-title">
                        </button>
                    </li>
                    <li id="mobile-lang-switcher" class="mobile-only"><a href="#">Language</a></li>
                </ul>
            </nav>

            <button class="search-toggle-btn">
                <img src="{{ asset('assets/logo-search.png') }}" alt="Ikon Cari">
            </button>
        </div>
    </div>
</header>
