@extends('layouts.app')

@section('title', 'Semua Produk')

@section('content')
<main>
    <section class="all-products-page">
        <div class="container">
            <h1 class="page-title" data-translate-key="all-products-title">Semua Produk</h1>
            
            <!-- Category Filters -->
            <div id="category-filters" class="category-filters">
                <button onclick="window.location.href='{{ route('products.index', array_merge(request()->query(), ['category' => null])) }}'"
                        class="{{ !request('category') ? 'active' : '' }}"
                        data-translate-key="all-categories">
                    Semua
                </button>
                @foreach ($categories as $cat)
                <button onclick="window.location.href='{{ route('products.index', array_merge(request()->query(), ['category' => $cat->slug])) }}'"
                        class="{{ request('category') === $cat->slug ? 'active' : '' }}">
                    {{ $cat->name }}
                </button>
                @endforeach
            </div>

            <!-- Sorting Controls -->
            <div class="sorting-controls">
                <label for="sort-products" data-translate-key="sort-title">Urutkan berdasarkan:</label>
                <select id="sort-products" onchange="window.location.href = this.value;">
                    <option value="{{ route('products.index', array_merge(request()->query(), ['sort' => 'default'])) }}" {{ request('sort') === 'default' || !request('sort') ? 'selected' : '' }}>Default</option>
                    <option value="{{ route('products.index', array_merge(request()->query(), ['sort' => 'price_asc'])) }}" {{ request('sort') === 'price_asc' ? 'selected' : '' }} data-translate-key="sort-price-asc">Harga: Terendah ke Tertinggi</option>
                    <option value="{{ route('products.index', array_merge(request()->query(), ['sort' => 'price_desc'])) }}" {{ request('sort') === 'price_desc' ? 'selected' : '' }} data-translate-key="sort-price-desc">Harga: Tertinggi ke Terendah</option>
                    <option value="{{ route('products.index', array_merge(request()->query(), ['sort' => 'name_asc'])) }}" {{ request('sort') === 'name_asc' ? 'selected' : '' }} data-translate-key="sort-name-asc">Nama: A-Z</option>
                    <option value="{{ route('products.index', array_merge(request()->query(), ['sort' => 'name_desc'])) }}" {{ request('sort') === 'name_desc' ? 'selected' : '' }} data-translate-key="sort-name-desc">Nama: Z-A</option>
                    <option value="{{ route('products.index', array_merge(request()->query(), ['sort' => 'stock_desc'])) }}" {{ request('sort') === 'stock_desc' ? 'selected' : '' }} data-translate-key="sort-stock-desc">Stok: Terbanyak</option>
                    <option value="{{ route('products.index', array_merge(request()->query(), ['sort' => 'stock_asc'])) }}" {{ request('sort') === 'stock_asc' ? 'selected' : '' }} data-translate-key="sort-stock-asc">Stok: Paling Sedikit</option>
                </select>
            </div>

            <!-- Products Grid -->
            <div id="all-products-grid" class="product-grid">
                @forelse ($products as $product)
                <article class="product-card">
                    <a href="{{ route('products.show', $product) }}" class="product-image-link">
                        <img src="{{ asset($product->images[0] ?? 'assets/logo-minecart.png') }}" alt="{{ $product->title_id }}">
                    </a>
                    <div class="product-card-body">
                        <h3>
                            <a href="{{ route('products.show', $product) }}" class="product-title-link" data-title-id="{{ $product->title_id }}" data-title-en="{{ $product->title_en }}">
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
                    <p style="font-family: var(--font-heading); font-size: 1rem; color: var(--text-color); margin-bottom: 10px;" data-translate-key="no-products-found">Tidak Ada Produk Ditemukan</p>
                    <p style="font-size: 0.9rem; color: var(--text-color); opacity: 0.7;" data-translate-key="no-products-found-desc">Coba gunakan kata kunci pencarian atau kategori lain.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>
</main>
@endsection
