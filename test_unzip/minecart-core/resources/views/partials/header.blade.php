<header>
    <!-- Bagian header atas (Top Bar) -->
    <div class="header-top">
        <div class="container header-container">
            <div class="social-media">
                <span data-translate-key="follow-us-title">Ikuti Kami di</span>
                <a href="https://www.instagram.com/varelrivaldi_hutabarat/" target="_blank"><img src="{{ asset('assets/logo-instagram.webp') }}" alt="Instagram" class="logo-ig" title="Instagram"></a>
                <a href="https://www.facebook.com/varel.rival.9" target="_blank"><img src="{{ asset('assets/logo-facebook.webp') }}" alt="Facebook" class="logo-fb" title="Facebook"></a>
                <a href="https://wa.me/6282275065026" target="_blank"><img src="{{ asset('assets/logo-whatsapp.webp') }}" alt="WhatsApp" class="logo-wa" title="WhatsApp"></a>
                <a href="https://github.com/pangeranvalerensco-maker" target="_blank"><img src="{{ asset('assets/logo-github.jpg') }}" alt="GitHub" class="logo-github" title="GitHub"></a>
            </div>
            <nav class="header-top-nav">
                <ul>
                    <li><a href="{{ route('about') }}" data-translate-key="about-us-title" class="a-header-top">Tentang Kami</a></li>
                    <li><a href="{{ route('help') }}" data-translate-key="help-title" class="a-header-top">Bantuan</a></li>
                    <li class="language-selector-wrapper">
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
                </ul>
            </nav>
        </div>
    </div>

    <!-- Bagian Utama Header (Logo, Search, Actions) -->
    <div class="header-main">
        <div class="container header-container" style="display: flex; align-items: center; justify-content: space-between; gap: 30px;">
            <div class="header-main-left" style="flex-shrink: 0; display: flex; align-items: center;">
                <a href="{{ route('home') }}" class="logo">
                    <img src="{{ asset('assets/logo-minecart.png') }}" alt="MineCart Logo">
                    <span>MineCart</span>
                </a>
                <button class="hamburger-btn mobile-only">
                    <span></span><span></span><span></span>
                </button>
            </div>

            <!-- Search Bar ala E-commerce (Tengah) -->
            <div class="header-search-container" style="flex-grow: 1; max-width: 800px;">
                <form class="search-bar ecom-search" action="{{ route('products.index') }}" method="GET">
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari di MineCart..." data-translate-key="search-title" required>
                    <button type="submit" title="Cari" data-translate-key="search-btn">
                        <img src="{{ asset('assets/logo-search.png') }}" alt="Cari">
                    </button>
                </form>
            </div>

            <!-- Action Area (Kanan) -->
            <div class="header-main-right desktop-only" style="display: flex; align-items: center; gap: 20px; flex-shrink: 0;">
                <!-- Keranjang -->
                @php
                    $headerCart = session()->get('cart', []);
                    $headerCartCount = array_sum(array_column($headerCart, 'quantity'));
                @endphp
                <div class="cart-icon-wrapper ecom-cart">
                    <a href="{{ route('cart.index') }}" title="Keranjang Belanja" data-translate-key="cart-link-title">
                        <img src="{{ asset('assets/logo-keranjang-gelap.png') }}" alt="Keranjang" class="icon-nav" id="cart-icon-img">
                        <span id="cart-counter" class="cart-counter {{ $headerCartCount > 0 ? 'visible' : '' }}">{{ $headerCartCount }}</span>
                    </a>
                    
                    <div id="cart-preview-dropdown" class="cart-preview">
                        <div class="cart-preview-header">
                            <h4 id="cart-preview-title">Keranjang Belanja ({{ $headerCartCount }})</h4>
                            <a href="{{ route('cart.index') }}" id="cart-preview-view-link" data-translate-key="view-cart-btn">Lihat Keranjang</a>
                        </div>
                        <div id="cart-preview-items">
                            @include('partials.cart_preview_items')
                        </div>
                    </div>
                </div>

                <div class="v-divider"></div>

                <!-- Theme Toggle -->
                <button id="theme-toggle-btn" class="theme-button" title="Ubah Tema" data-translate-key="theme-toggle-title">
                    <img id="theme-icon" src="{{ asset('assets/logo-gelap.png') }}" alt="Tema" data-translate-key="theme-link-title">
                </button>

                <div class="v-divider"></div>

                <!-- Account Menu -->
                <div id="account-menu">
                    @guest
                    <div class="is-logged-out" id="account-menu-desktop">
                        <a href="{{ route('login') }}" class="btn btn-secondary btn-outline" data-translate-key="login">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-primary" data-translate-key="register">Daftar</a>
                    </div>
                    @else
                    <div class="is-logged-in account-dropdown-container" id="account-menu-desktop">
                        <div class="account-dropdown-toggle">
                            <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                            <span>{{ explode(' ', auth()->user()->name)[0] }}</span>
                        </div>
                        <div class="account-dropdown-menu">
                            <a href="{{ route('account.index') }}" data-translate-key="my-profile">My Profile</a>
                            <a href="{{ route('account.orders') }}" data-translate-key="order-history">Riwayat Pesanan</a>
                            <a href="{{ route('wishlists.index') }}">Wishlist Saya</a>
                            <a href="{{ route('chat.index') }}">Pesan (Chat)</a>
                            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" class="logout-btn" data-translate-key="logout">Logout</button>
                            </form>
                        </div>
                    </div>
                    @endguest
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian Bawah Header (Navigasi Utama) -->
    <div class="header-bottom">
        <div class="container header-container">
            <nav class="header-main-nav">
                <ul>
                    <li class="desktop-only"><a href="{{ route('home') }}" data-translate-key="home-title" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a></li>
                    <li class="desktop-only"><a href="{{ route('products.index') }}" data-translate-key="all-products-title" class="{{ request()->routeIs('products.index') ? 'active' : '' }}">Semua Produk</a></li>
                    <li class="desktop-only"><a href="{{ route('home') }}#recommended" data-translate-key="recommended-title">Rekomendasi</a></li>
                    @auth
                        <li class="desktop-only"><a href="{{ route('account.orders') }}" data-translate-key="order-history" class="{{ request()->routeIs('account.orders') ? 'active' : '' }}">Riwayat Pesanan</a></li>
                        <li class="desktop-only"><a href="{{ route('wishlists.index') }}" class="{{ request()->routeIs('wishlists.*') ? 'active' : '' }}">Wishlist</a></li>
                        <li class="desktop-only"><a href="{{ route('chat.index') }}" class="{{ request()->routeIs('chat.*') ? 'active' : '' }}">Chat</a></li>
                        @if(auth()->user()->is_seller)
                            <li class="desktop-only"><a href="{{ route('seller.products.index') }}" class="{{ request()->routeIs('seller.*') ? 'active' : '' }}" data-translate-key="my-store">Toko Saya</a></li>
                        @else
                            <li class="desktop-only"><a href="{{ route('store.create') }}" data-translate-key="open-store">Buka Toko</a></li>
                        @endif
                    @else
                        <li class="desktop-only"><a href="{{ route('login') }}" data-translate-key="open-store">Buka Toko</a></li>
                    @endauth

                    <!-- Item Khusus Mobile (Disembunyikan di Desktop) -->
                    @guest
                    <li class="mobile-only"><a href="{{ route('login') }}" data-translate-key="login">Masuk</a></li>
                    <li class="mobile-only"><a href="{{ route('register') }}" data-translate-key="register">Daftar</a></li>
                    @else
                    <li class="mobile-only"><a href="{{ route('account.index') }}" data-translate-key="my-account">Akun Saya</a></li>
                    <li class="mobile-only"><a href="{{ route('account.orders') }}" data-translate-key="order-history">Riwayat Pesanan</a></li>
                    <li class="mobile-only"><a href="{{ route('wishlists.index') }}">Wishlist Saya</a></li>
                    <li class="mobile-only"><a href="{{ route('chat.index') }}">Chat</a></li>
                    @if(auth()->user()->is_seller)
                        <li class="mobile-only"><a href="{{ route('seller.products.index') }}" data-translate-key="my-store">Toko Saya</a></li>
                    @else
                        <li class="mobile-only"><a href="{{ route('store.create') }}" data-translate-key="open-store">Buka Toko</a></li>
                    @endif
                    <li class="mobile-only">
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0; padding: 0;">
                            @csrf
                            <button type="submit" class="mobile-logout" data-translate-key="logout">Logout</button>
                        </form>
                    </li>
                    @endguest
                    <li class="mobile-only"><a href="{{ route('home') }}#recommended" data-translate-key="recommended-title">Rekomendasi</a></li>
                    <li class="mobile-only"><a href="{{ route('home') }}" data-translate-key="home-title">Beranda</a></li>
                    <li class="mobile-only"><a href="{{ route('products.index') }}" data-translate-key="all-products-title">Semua Produk</a></li>
                    <li class="mobile-only"><a href="{{ route('about') }}" data-translate-key="about-us-title">Tentang Kami</a></li>
                    <li class="mobile-only"><a href="{{ route('help') }}" data-translate-key="help-title">Bantuan</a></li>
                    <li id="mobile-lang-switcher" class="mobile-only"><a href="#"></a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>
