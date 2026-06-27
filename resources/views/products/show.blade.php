@extends('layouts.app')

@section('title', $product->title_id)

@section('content')
<main>
    <div class="container">
        <!-- Product Detail Layout -->
        <div class="product-detail-layout">
            <!-- Product Images -->
            <div class="product-detail-images" id="product-images">
                <img id="main-product-image" src="{{ asset($product->images[0] ?? 'assets/logo-minecart.png') }}" alt="{{ $product->title_id }}">
                
                @if (count($product->images) > 1)
                <div class="thumbnails">
                    @foreach ($product->images as $index => $img)
                    <img class="{{ $index === 0 ? 'active' : '' }}" src="{{ asset($img) }}" alt="Thumbnail {{ $index + 1 }}" onclick="changeMainImage(this)">
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="product-detail-info">
                <h1 data-title-id="{{ $product->title_id }}" data-title-en="{{ $product->title_en }}">
                    {{ $product->title_id }}
                </h1>
                <p class="category-tag">{{ $product->category?->name ?? 'Uncategorized' }}</p>
                <p class="price-detail">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <p id="product-description" data-description-id="{{ $product->description_id }}" data-description-en="{{ $product->description_en }}">
                    {{ $product->description_id }}
                </p>
                <p id="product-stock">
                    <span data-translate-key="product-stock-label">Stok:</span> {{ $product->stock }}
                </p>

                <!-- Shop / Seller Info -->
                <div class="product-location-info">
                    <h3 data-translate-key="product-seller-title">Penjual:</h3>
                    <p><strong data-translate-key="seller-name-label">Nama Toko:</strong> <span>{{ optional($product->seller)->store_name ?? 'MineCart Official' }}</span></p>
                    <p><strong data-translate-key="label-address">Alamat Toko:</strong> <span>{{ $product->address }}</span></p>
                </div>

                <!-- Add to Cart Button -->
                <form action="{{ route('cart.add', $product) }}" method="POST" class="js-add-to-cart-form" style="margin-top: 2rem; display: block;">
                    @csrf
                    <button type="submit" id="add-to-cart-btn" class="cta-button" {{ $product->stock <= 0 ? 'disabled style=cursor:not-allowed;opacity:0.6;' : '' }} data-translate-key="buy-button">
                        Tambah ke Keranjang
                    </button>
                </form>
            </div>
        </div>

        <!-- Related Products Section -->
        <section class="featured-products related-products-section">
            <div class="container">
                <h2 data-translate-key="related-products-title">Mungkin Anda Suka</h2>
                <div class="product-grid" id="related-products-grid">
                    @forelse ($relatedProducts as $related)
                    <article class="product-card">
                        <a href="{{ route('products.show', $related) }}" class="product-image-link">
                            <img src="{{ asset($related->images[0] ?? 'assets/logo-minecart.png') }}" alt="{{ $related->title_id }}">
                        </a>
                        <div class="product-card-body">
                            <h3>
                                <a href="{{ route('products.show', $related) }}" class="product-title-link" data-title-id="{{ $related->title_id }}" data-title-en="{{ $related->title_en }}">
                                    {{ $related->title_id }}
                                </a>
                            </h3>
                            <p class="description" data-description-id="{{ $related->description_id }}" data-description-en="{{ $related->description_en }}">
                                {{ $related->description_id }}
                            </p>
                        </div>
                        <div class="product-card-footer">
                            <span class="price">Rp {{ number_format($related->price, 0, ',', '.') }}</span>
                            <form action="{{ route('cart.add', $related) }}" method="POST" class="js-add-to-cart-form" style="margin: 0; display: inline-flex; flex: 1 1 auto; justify-content: flex-end;">
                                @csrf
                                <button type="submit" class="buy-btn" {{ $related->stock <= 0 ? 'disabled' : '' }} data-product-id="{{ $related->id }}" data-translate-key="buy-button" style="width: 100%;">Tambah ke Keranjang</button>
                            </form>
                        </div>
                    </article>
                    @empty
                    <div class="empty-state" style="grid-column: 1 / -1; text-align: center; padding: 20px;">
                        <p style="font-size: 0.9rem; color: var(--text-color); opacity: 0.7;" data-translate-key="no-related-products">Tidak ada produk terkait lainnya.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
</main>

<script>
function changeMainImage(el) {
    document.getElementById('main-product-image').src = el.src;
    const siblings = el.parentNode.getElementsByTagName('img');
    for (let i = 0; i < siblings.length; i++) {
        siblings[i].classList.remove('active');
    }
    el.classList.add('active');
}
</script>
@endsection
