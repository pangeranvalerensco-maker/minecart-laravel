<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MineCart - @yield('title', 'Beranda')</title>
    <link rel="icon" href="{{ asset('assets/logo-minecart.png') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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
</body>
</html>
