@extends('layouts.app')

@section('title', $product->title_id)
@section('meta_description', Str::limit(strip_tags($product->description_id), 150))
@section('og_title', $product->title_id)
@section('og_description', Str::limit(strip_tags($product->description_id), 150))
@section('og_image', $product->image_url)
@section('og_type', 'product')

@section('content')
<main>
    <div class="container">
        <!-- Product Detail Layout -->
        <div class="product-detail-layout">
            <!-- Product Images -->
            <div class="product-detail-images" id="product-images">
                <img id="main-product-image" src="{{ $product->image_url }}" alt="{{ $product->title_id }}">
                
                @if (count($product->images ?? []) > 1)
                <div class="thumbnails">
                    @foreach ($product->all_image_urls as $index => $imgUrl)
                    <img class="{{ $index === 0 ? 'active' : '' }}" src="{{ $imgUrl }}" alt="Thumbnail {{ $index + 1 }}" onclick="changeMainImage(this)">
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="product-detail-info" style="position: relative;">
                @php
                    $isWishlisted = auth()->check() ? \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists() : false;
                @endphp
                @auth
                <button type="button" onclick="toggleWishlist({{ $product->id }}, this)" style="position: absolute; right: 0; top: 0; background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" class="wishlist-btn" title="Tambah ke Wishlist">
                    {{ $isWishlisted ? '❤️' : '🤍' }}
                </button>
                @endauth
                <h1 data-title-id="{{ $product->title_id }}" data-title-en="{{ $product->title_en }}" style="padding-right: 40px;">
                    {{ $product->title_id }}
                </h1>
                <p class="category-tag">{{ $product->category?->name ?? 'Uncategorized' }}</p>
                <div style="margin-bottom: 10px; color: #f4a261; font-size: 0.9rem;">
                    @if($product->average_rating > 0)
                        <span style="font-weight: bold;">⭐ {{ number_format($product->average_rating, 1) }}</span>
                        <span style="color: #666; margin-left: 5px;">({{ $product->reviews->count() }} ulasan)</span>
                    @else
                        <span style="color: #999;">Belum ada ulasan</span>
                    @endif
                </div>
                @if($product->is_flash_sale_active)
                    <div style="display: flex; align-items: baseline; gap: 10px;">
                        <p class="price-detail">Rp {{ number_format($product->current_price, 0, ',', '.') }}</p>
                        <p style="text-decoration: line-through; color: #94a3b8; font-size: 1.1rem;">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <span style="background: #fee2e2; color: #ef4444; padding: 2px 6px; border-radius: 4px; font-size: 0.8rem; font-weight: bold;">⚡ FLASH SALE</span>
                    </div>
                @else
                    <p class="price-detail">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                @endif
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

                    @if(auth()->check() && auth()->id() !== $product->user_id && $product->user_id)
                        <form action="{{ route('chat.start', $product->user_id) }}" method="POST" style="margin-top: 15px;">
                            @csrf
                            <button type="submit" class="btn btn-secondary" style="width: 100%; border-radius: 6px; padding: 10px; font-weight: 500; display: flex; align-items: center; justify-content: center; gap: 8px; background: transparent; border: 2px solid var(--accent-color); color: var(--text-color); cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='var(--accent-color)'; this.style.color='var(--accent-text-color)';" onmouseout="this.style.background='transparent'; this.style.color='var(--text-color)';">
                                💬 Chat Penjual
                            </button>
                        </form>
                    @elseif(!auth()->check())
                        <div style="margin-top: 15px; text-align: center;">
                            <a href="{{ route('login') }}" style="color: var(--accent-color); font-size: 0.9rem; text-decoration: none;">Login untuk Chat Penjual</a>
                        </div>
                    @endif
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

        <!-- Reviews Section -->
        <section style="margin-top: 3rem;">
            <div style="background-color: var(--card-bg); border: 1px solid var(--subtle-border-color); border-radius: 8px; padding: 20px;">
                <h2 style="font-family: var(--font-heading); font-size: 1.5rem; margin-bottom: 20px; border-bottom: 1px solid var(--subtle-border-color); padding-bottom: 10px;">Ulasan Produk</h2>
                
                @forelse($product->reviews as $review)
                    <div style="border-bottom: 1px solid var(--subtle-border-color); padding-bottom: 15px; margin-bottom: 15px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                            <div style="font-weight: 500;">{{ $review->user->name }}</div>
                            <div style="color: #666; font-size: 0.85rem;">{{ $review->created_at->format('d M Y') }}</div>
                        </div>
                        <div style="color: #f4a261; margin-bottom: 10px; font-size: 1.2rem; letter-spacing: 2px;">
                            {!! str_repeat('★', $review->rating) !!}{!! str_repeat('☆', 5 - $review->rating) !!}
                        </div>
                        @if($review->comment)
                            <p style="font-size: 0.95rem; margin-bottom: 10px; white-space: pre-line;">{{ $review->comment }}</p>
                        @endif
                        @if($review->image_path)
                            <img src="{{ asset('storage/' . $review->image_path) }}" alt="Review Image" style="max-width: 150px; border-radius: 4px; border: 1px solid var(--subtle-border-color); cursor: pointer;" onclick="window.open(this.src)">
                        @endif
                    </div>
                @empty
                    <div style="text-align: center; color: #999; padding: 20px 0;">
                        Belum ada ulasan untuk produk ini.
                    </div>
                @endforelse
            </div>
        </section>

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

function toggleWishlist(productId, btn) {
    btn.style.transform = 'scale(1.2)';
    setTimeout(() => btn.style.transform = 'scale(1)', 200);

    fetch(`/wishlists/toggle/${productId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'added') {
            btn.textContent = '❤️';
        } else if (data.status === 'removed') {
            btn.textContent = '🤍';
        }
    })
    .catch(err => console.error(err));
}
</script>
@endsection
