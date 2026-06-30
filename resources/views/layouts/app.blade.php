<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MineCart - @yield('title', 'Beranda')</title>
    
    <!-- SEO & Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'MineCart - Platform e-commerce terbaik untuk kebutuhan gaming dan gaya hidup Anda.')">
    <meta name="keywords" content="@yield('meta_keywords', 'minecart, ecommerce, gaming, belanja, online')">
    <meta property="og:title" content="@yield('og_title', 'MineCart E-Commerce')">
    <meta property="og:description" content="@yield('og_description', 'Platform e-commerce terbaik untuk kebutuhan gaming dan gaya hidup Anda.')">
    <meta property="og:image" content="@yield('og_image', asset('assets/logo-minecart.png'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="@yield('og_type', 'website')">

    <!-- PWA Setup -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#0f172a">
    <link rel="apple-touch-icon" href="{{ asset('assets/logo-minecart.png') }}">

    <link rel="icon" href="{{ asset('assets/logo-minecart.png') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=2.0">
    <link rel="stylesheet" href="{{ asset('css/seller.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Press+Start+2P&display=swap" rel="stylesheet">
    <script>
        // Tema langsung diaplikasikan sebelum DOM dirender untuk mencegah screen flash
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark-mode');
            } else {
                document.documentElement.classList.remove('dark-mode');
            }
        })();
    </script>
</head>
<body>
    <script>
        // Samakan class body dengan tema documentElement
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            if (savedTheme === 'dark') {
                document.body.classList.add('dark-mode');
            } else {
                document.body.classList.remove('dark-mode');
            }
        })();
    </script>

    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <div id="toast-container"></div>

    <script>
        // Kirim path asset dinamis ke JavaScript klien
        window.minecartAssets = {
            logoTerang: "{{ asset('assets/logo-terang.png') }}",
            logoGelap: "{{ asset('assets/logo-gelap.png') }}",
            cartGelap: "{{ asset('assets/logo-keranjang-gelap.png') }}",
            cartTerang: "{{ asset('assets/logo-keranjang-terang.png') }}"
        };
    </script>
    <script src="{{ asset('js/ui.js') }}"></script>
    <script src="{{ asset('js/cart-actions.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            @if (session('success'))
                showToast("{{ session('success') }}", 'success');
            @endif
            @if (session('error'))
                showToast("{{ session('error') }}", 'error');
            @endif
            @if (session('warning'))
                showToast("{{ session('warning') }}", 'warning');
            @endif
        });

        // Register Service Worker for PWA
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').then(registration => {
                    console.log('ServiceWorker registration successful with scope: ', registration.scope);
                }).catch(error => {
                    console.log('ServiceWorker registration failed: ', error);
                });
            });
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Sembunyikan iklan diskon.com
            document.querySelectorAll('div').forEach(div => {
                if(div.innerHTML.includes('Hosting gratis dari Diskon.com')) {
                    div.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
