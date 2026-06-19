@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<section class="hero">
    <!-- wadah untuk menampilkan semua gambar slide carousel dan isinya-->
    <div class="carousel-container">
        <!-- setiap slide berisi gambar yang akan ditampilkan -->
        <div class="carousel-slide">
            <img src="{{ asset('assets/carousel-1.jpg') }}" alt="Gaming Accessories">
        </div>
        <div class="carousel-slide">
            <img src="{{ asset('assets/carousel-2.jpg') }}" alt="Organic Coffee">
        </div>
        <div class="carousel-slide">
            <img src="{{ asset('assets/carousel-3.jpg') }}" alt="Fashion Store">
        </div>
    </div>

    <div class="hero-overlay"></div> <!-- Overlay untuk efek visual pada gambar slide -->

    <div class="hero-content">
        <!-- Teks yang ditampilkan di atas gambar slide -->
        <h1 data-translate-key="hero-title">Koleksi Terbaru Musim Ini</h1>
        <p data-translate-key="hero-subtitle">Temukan gaya terbaik Anda dengan produk pilihan berkualitas tinggi.</p>
        <a href="#" class="cta-button" data-translate-key="hero-cta">Lihat Semua Produk</a>
    </div>
    <button id="prevBtn" class="carousel-btn prev">&#10094;</button> <!-- Tombol ke slide sebelumnya -->
    <button id="nextBtn" class="carousel-btn next">&#10095;</button> <!-- Tombol ke slide berikutnya -->
</section>

<section class="featured-products" id="recommended">
    <!-- Bagian untuk menampilkan produk rekomendasi -->
    <div class="container">
        <h2 class="rekom-mobile" data-translate-key="featured-title">Produk Rekomendasi</h2>
        <div class="product-grid">
            @forelse ($recommendedProducts as $product)
            <article class="product-card">
                <a href="#" class="product-image-link">
                    <img src="{{ asset($product->images[0] ?? 'assets/logo-minecart.png') }}" alt="{{ $product->title_id }}">
                </a>
                <div class="product-card-body">
                    <h3>
                        <a href="#" class="product-title-link" data-title-id="{{ $product->title_id }}" data-title-en="{{ $product->title_en }}">
                            {{ $product->title_id }}
                        </a>
                    </h3>
                    <p class="description" data-description-id="{{ $product->description_id }}" data-description-en="{{ $product->description_en }}">
                        {{ $product->description_id }}
                    </p>
                </div>
                <div class="product-card-footer">
                    <span class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    <button class="buy-btn" disabled data-product-id="{{ $product->id }}" data-translate-key="buy-button">Tambah ke Keranjang</button>
                </div>
            </article>
            @empty
            <div class="empty-state" style="grid-column: 1 / -1; text-align: center; padding: 40px 20px;">
                <img src="{{ asset('assets/logo-minecart.png') }}" alt="Empty State" style="filter: grayscale(1); opacity: 0.3; height: 100px; margin-bottom: 20px;">
                <p style="font-family: var(--font-heading); font-size: 1rem; color: var(--text-color); margin-bottom: 10px;">Tidak Ada Produk Rekomendasi</p>
                <p style="font-size: 0.9rem; color: var(--text-color); opacity: 0.7;">Silakan jalankan seeder untuk mengisi data produk.</p>
            </div>
            @endforelse
        </div>
        <div class="see-more-container">
            <!-- Tombol untuk melihat lebih banyak produk -->
            <a href="#" class="cta-button" data-translate-key="see-more-btn">Lihat Lainnya</a>
        </div>
    </div>
</section>

<div id="cs-popup" class="cs-popup hidden-element">
    <!-- Pop-up selamat datang, hanya muncul sekali di index (harus klik silang biar ga muncul lagi) -->
    <div class="cs-popup-header">
        <h3 data-translate-key="cs-title">Customer Service</h3>
        <button class="close-btn">x</button>
    </div>
    <div class="cs-popup-body">
        <p data-translate-key="cs-welcome">Selamat datang di MineCart Web! Temukan berbagai produk berkualitas tinggi dengan harga terbaik.</p>
        <p>Butuh bantuan? Hubungi tim MineCart melalui informasi kontak yang tersedia.</p>
    </div>
</div>
@endsection
