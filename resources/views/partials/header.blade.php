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
                    <li><a href="{{ route('about') }}" data-translate-key="about-us-title" class="a-header-top">Tentang Kami</a></li>
                    <li><a href="{{ route('help') }}" data-translate-key="help-title" class="a-header-top">Bantuan</a></li>
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
                        @guest
                        <div class="is-logged-out" id="account-menu-desktop">
                            <a href="{{ route('login') }}" class="btn btn-secondary" data-translate-key="login">Masuk</a>
                            <a href="{{ route('register') }}" class="btn btn-primary" data-translate-key="register">Daftar</a>
                        </div>
                        @else
                        <div class="is-logged-in" id="account-menu-desktop" style="display: flex; align-items: center; gap: 15px;">
                            <span style="font-weight: 500; font-size: 0.9rem;">Halo, {{ explode(' ', auth()->user()->name)[0] }}</span>
                            <a href="{{ route('account.index') }}" class="btn btn-secondary" style="padding: 6px 12px; font-size: 0.85rem;" data-translate-key="my-account">Akun Saya</a>
                            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" class="btn btn-primary" style="padding: 6px 12px; font-size: 0.85rem;" data-translate-key="logout">Logout</button>
                            </form>
                        </div>
                        @endguest
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
                    @guest
                    <!-- Tautan untuk masuk (hanya terlihat di mobile dan saat pengguna belum masuk) -->
                    <li class="mobile-only"><a href="{{ route('login') }}" data-translate-key="login">Masuk</a></li>
                    <li class="mobile-only"><a href="{{ route('register') }}" data-translate-key="register">Daftar</a></li>
                    @else
                    <!-- Tautan untuk akun pengguna (hanya terlihat di mobile dan saat pengguna sudah masuk) -->
                    <li class="mobile-only"><a href="{{ route('account.index') }}" data-translate-key="my-account">Akun Saya</a></li>
                    <li class="mobile-only">
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0; padding: 0;">
                            @csrf
                            <button type="submit" style="background: none; border: none; color: inherit; font-family: inherit; font-size: inherit; padding: 10px 15px; width: 100%; text-align: left; cursor: pointer; border-bottom: 1px solid var(--subtle-border-color);" data-translate-key="logout">Logout</button>
                        </form>
                    </li>
                    @endguest

                    <li><a href="{{ route('home') }}#recommended" data-translate-key="recommended-title">Rekomendasi</a></li>
                    <li><a href="{{ route('home') }}" data-translate-key="home-title" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a></li>
                    <li><a href="{{ route('products.index') }}" data-translate-key="all-products-title" class="{{ request()->routeIs('products.index') ? 'active' : '' }}">Semua Produk</a></li>

                    <!-- Tautan untuk halaman tentang dan bantuan (hanya terlihat di mobile) -->
                    <li class="mobile-only"><a href="{{ route('about') }}" data-translate-key="about-us-title">Tentang Kami</a></li>
                    <li class="mobile-only"><a href="{{ route('help') }}" data-translate-key="help-title">Bantuan</a></li>

                    <!-- Keranjang belanja -->
                    @php
                        $headerCart = session()->get('cart', []);
                        $headerCartCount = 0;
                        foreach ($headerCart as $item) {
                            $headerCartCount += $item['quantity'] ?? 0;
                        }
                    @endphp
                    <li class="cart-icon-wrapper">
                        <a href="{{ route('cart.index') }}" title="Keranjang Belanja" data-translate-key="cart-link-title">
                            <img src="{{ asset('assets/logo-keranjang-gelap.png') }}" alt="Keranjang" class="icon-nav" id="cart-icon-img">
                            <span id="cart-counter" class="cart-counter visible">{{ $headerCartCount }}</span>
                            <span class="cart-text-mobile">Keranjang Belanja</span>
                        </a>

                        <div id="cart-preview-dropdown" class="cart-preview">
                            <div class="cart-preview-header">
                                <h4 id="cart-preview-title">Keranjang Belanja ({{ $headerCartCount }})</h4>
                                <a href="{{ route('cart.index') }}" id="cart-preview-view-link" data-translate-key="view-cart-btn">Lihat Keranjang</a>
                            </div>
                            <div id="cart-preview-items">
                                @php
                                    $previewItems = array_slice($headerCart, 0, 3, true);
                                    $previewProductIds = array_keys($previewItems);
                                    $previewProducts = \App\Models\Product::whereIn('id', $previewProductIds)->get()->keyBy('id');
                                @endphp
                                @forelse($previewItems as $productId => $item)
                                    @if(isset($previewProducts[$productId]))
                                    <div class="cart-preview-item" style="display: flex; gap: 10px; align-items: center; padding: 10px; border-bottom: 1px solid var(--subtle-border-color);">
                                        <img src="{{ asset($previewProducts[$productId]->images[0] ?? 'assets/logo-minecart.png') }}" alt="{{ $previewProducts[$productId]->title_id }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                        <div class="cart-preview-details" style="flex-grow: 1;">
                                            <p class="cart-preview-name" style="margin: 0; font-size: 0.9rem; font-weight: 500;">{{ $previewProducts[$productId]->title_id }}</p>
                                            <p class="cart-preview-price" style="margin: 5px 0 0; font-size: 0.85rem; color: var(--accent-color);">Rp {{ number_format($previewProducts[$productId]->price, 0, ',', '.') }} x {{ $item['quantity'] }}</p>
                                        </div>
                                    </div>
                                    @endif
                                @empty
                                    <div style="padding: 15px; text-align: center; color: var(--text-color); opacity: 0.7;">
                                        <p class="cart-preview-empty" data-translate-key="cart-empty-message" style="margin: 0;">Keranjang Anda kosong.</p>
                                    </div>
                                @endforelse
                                @if(count($headerCart) > 3)
                                    <div style="padding: 10px; text-align: center; font-size: 0.85rem; font-style: italic; color: var(--text-color); opacity: 0.8;">
                                        <p class="cart-preview-more" style="margin: 0;">... dan {{ count($headerCart) - 3 }} barang lainnya</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </li>
                    <li>
                        <button id="theme-toggle-btn" class="theme-button" title="Ubah Tema" data-translate-key="theme-toggle-title">
                            <img id="theme-icon" src="{{ asset('assets/logo-gelap.png') }}" alt="Tema" data-translate-key="theme-link-title">
                        </button>
                    </li>
                    <li id="mobile-lang-switcher" class="mobile-only"><a href="#"></a></li>
                </ul>
            </nav>

            <button class="search-toggle-btn">
                <img src="{{ asset('assets/logo-search.png') }}" alt="Ikon Cari">
            </button>
        </div>
    </div>
</header>
