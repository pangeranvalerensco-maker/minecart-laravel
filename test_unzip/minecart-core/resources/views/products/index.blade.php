@extends('layouts.app')

@section('title', 'Semua Produk')

@section('content')
<main>
    <div class="container" style="padding-top: 20px; padding-bottom: 40px;">
        
        <!-- Breadcrumb / Header -->
        <div style="margin-bottom: 20px;">
            @if(request('q'))
                <h1 style="font-size: 1.5rem; margin: 0; font-family: var(--font-heading);">
                    <span data-translate-key="search-results-for">Menampilkan hasil untuk</span>
                    <span style="color: var(--accent-color);">"{{ request('q') }}"</span>
                </h1>
            @else
                <h1 style="font-size: 1.5rem; margin: 0; font-family: var(--font-heading);" data-translate-key="all-products-title">Semua Produk</h1>
            @endif
        </div>

        <div style="display: flex; gap: 20px; align-items: flex-start;">
            
            <!-- Sidebar Filter -->
            <aside style="width: 250px; flex-shrink: 0; background: var(--card-bg); border-radius: 8px; padding: 20px; box-shadow: 0 1px 4px rgba(0,0,0,0.05); border: 1px solid var(--subtle-border-color); position: sticky; top: 90px; overflow-y: auto; max-height: calc(100vh - 100px);">
                
                <!-- Filter Form -->
                <form action="{{ route('products.index') }}" method="GET" id="filter-form">
                    <!-- Pertahankan parameter query lain (search, dll) -->
                    @if(request('q'))
                        <input type="hidden" name="q" value="{{ request('q') }}">
                    @endif
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif

                    <!-- Kategori -->
                    <div style="margin-bottom: 25px;">
                        <h3 style="font-size: 1rem; margin-bottom: 15px; font-weight: 600; color: var(--text-color);" data-translate-key="filter-category">Kategori</h3>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 0.9rem; color: var(--text-color);">
                                <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }} onchange="this.form.submit()" style="accent-color: var(--accent-color);">
                                <span data-translate-key="categories.Semua">Semua Kategori</span>
                            </label>
                            @foreach ($categories as $cat)
                                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 0.9rem; color: var(--text-color);">
                                    <input type="radio" name="category" value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'checked' : '' }} onchange="this.form.submit()" style="accent-color: var(--accent-color);">
                                    {{ $cat->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Harga -->
                    <div style="margin-bottom: 25px;">
                        <h3 style="font-size: 1rem; margin-bottom: 15px; font-weight: 600; color: var(--text-color);" data-translate-key="filter-price">Harga</h3>
                        
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <div style="display: flex; align-items: center; background: var(--body-bg); border: 1px solid var(--subtle-border-color); border-radius: 4px; padding: 5px 10px;">
                                <span style="color: #888; font-size: 0.85rem; margin-right: 5px;">Rp</span>
                                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Harga Minimum" data-translate-key="min-price" style="border: none; background: transparent; width: 100%; outline: none; color: var(--text-color); font-size: 0.85rem;" min="0">
                            </div>
                            <div style="display: flex; align-items: center; background: var(--body-bg); border: 1px solid var(--subtle-border-color); border-radius: 4px; padding: 5px 10px;">
                                <span style="color: #888; font-size: 0.85rem; margin-right: 5px;">Rp</span>
                                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Harga Maksimum" data-translate-key="max-price" style="border: none; background: transparent; width: 100%; outline: none; color: var(--text-color); font-size: 0.85rem;" min="0">
                            </div>
                        </div>
                        <button type="submit" style="width: 100%; margin-top: 10px; background: transparent; border: 1px solid var(--accent-color); color: var(--accent-color); padding: 8px; border-radius: 4px; cursor: pointer; font-weight: 500; font-size: 0.85rem; transition: all 0.2s;" onmouseover="this.style.background='var(--accent-color)'; this.style.color='#fff';" onmouseout="this.style.background='transparent'; this.style.color='var(--accent-color)';" data-translate-key="apply-price">
                            Terapkan Harga
                        </button>
                    </div>
                </form>
            </aside>

            <!-- Main Content Area -->
            <div style="flex-grow: 1;">
                
                <!-- Top Bar (Sort & Stats) -->
                <div style="display: flex; justify-content: space-between; align-items: center; background: var(--card-bg); padding: 15px 20px; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.05); border: 1px solid var(--subtle-border-color); margin-bottom: 20px;">
                    <div style="font-size: 0.9rem; color: #666;">
                        Menampilkan <span style="font-weight: 600; color: var(--text-color);">{{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }}</span> dari <span style="font-weight: 600; color: var(--text-color);">{{ $products->total() }}</span> barang
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: 0.9rem; color: #666;">Urutkan:</span>
                        <select onchange="window.location.href = this.value;" style="padding: 8px 12px; border: 1px solid var(--subtle-border-color); border-radius: 6px; background: var(--body-bg); color: var(--text-color); font-size: 0.9rem; outline: none; cursor: pointer;">
                            <option value="{{ route('products.index', array_merge(request()->query(), ['sort' => 'default'])) }}" {{ request('sort') === 'default' || !request('sort') ? 'selected' : '' }}>Paling Sesuai</option>
                            <option value="{{ route('products.index', array_merge(request()->query(), ['sort' => 'price_asc'])) }}" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Harga: Terendah ke Tertinggi</option>
                            <option value="{{ route('products.index', array_merge(request()->query(), ['sort' => 'price_desc'])) }}" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Harga: Tertinggi ke Terendah</option>
                            <option value="{{ route('products.index', array_merge(request()->query(), ['sort' => 'name_asc'])) }}" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Nama: A-Z</option>
                            <option value="{{ route('products.index', array_merge(request()->query(), ['sort' => 'name_desc'])) }}" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Nama: Z-A</option>
                        </select>
                    </div>
                </div>

                <!-- Product Grid -->
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px;">
                    @forelse ($products as $product)
                        <article class="product-card" style="background: var(--card-bg); border: 1px solid var(--subtle-border-color); border-radius: 8px; overflow: hidden; transition: transform 0.2s, box-shadow 0.2s; display: flex; flex-direction: column; cursor: pointer;" onclick="window.location='{{ route('products.show', $product) }}'" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.08)'" onmouseout="this.style.transform='none'; this.style.boxShadow='none'">
                            <div style="display: block; position: relative; padding-top: 100%; overflow: hidden;">
                                <img src="{{ $product->image_url }}" alt="{{ $product->title_id }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            
                            <div style="padding: 12px; display: flex; flex-direction: column; flex-grow: 1;">
                                <h3 style="margin: 0 0 5px 0; font-size: 0.9rem; font-weight: 500; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 38px; line-height: 1.2;">
                                    <span style="color: var(--text-color); text-decoration: none;" data-title-id="{{ $product->title_id }}" data-title-en="{{ $product->title_en }}">
                                        {{ $product->title_id }}
                                    </span>
                                </h3>
                                
                                <div style="font-size: 1.1rem; font-weight: bold; color: var(--accent-color); margin-bottom: 5px;">
                                    Rp{{ number_format($product->price, 0, ',', '.') }}
                                </div>
                                
                                <div style="font-size: 0.75rem; color: #666; margin-bottom: 5px; display: flex; align-items: center; gap: 5px;">
                                    <span>⭐ {{ number_format($product->average_rating, 1) }}</span>
                                    <span>|</span>
                                    <span>{{ rand(10, 500) }} Terjual</span>
                                </div>
                                
                                <div style="font-size: 0.75rem; color: #888; display: flex; align-items: center; gap: 4px; margin-bottom: 12px;">
                                    📍 {{ $product->address }}
                                </div>

                                <div style="margin-top: auto;" onclick="event.stopPropagation();">
                                    <form action="{{ route('cart.add', $product) }}" method="POST" class="js-add-to-cart-form" style="margin: 0;">
                                        @csrf
                                        <button type="submit" {{ $product->stock <= 0 ? 'disabled' : '' }} class="buy-btn" style="width: 100%; background: {{ $product->stock <= 0 ? 'var(--subtle-border-color)' : 'transparent' }}; color: {{ $product->stock <= 0 ? '#999' : 'var(--accent-color)' }}; border: 1px solid {{ $product->stock <= 0 ? 'var(--subtle-border-color)' : 'var(--accent-color)' }}; padding: 8px; border-radius: 4px; font-weight: 600; font-size: 0.85rem; cursor: {{ $product->stock <= 0 ? 'not-allowed' : 'pointer' }}; transition: all 0.2s;" onmouseover="if({{ $product->stock > 0 ? 'true' : 'false' }}) { this.style.background='var(--accent-color)'; this.style.color='#fff'; }" onmouseout="if({{ $product->stock > 0 ? 'true' : 'false' }}) { this.style.background='transparent'; this.style.color='var(--accent-color)'; }">
                                            {{ $product->stock <= 0 ? 'Habis' : 'Tambah' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: var(--card-bg); border-radius: 8px; border: 1px solid var(--subtle-border-color);">
                            <img src="{{ asset('assets/logo-search.png') }}" alt="Empty State" style="filter: grayscale(1); opacity: 0.3; height: 60px; margin-bottom: 20px;">
                            <p style="font-family: var(--font-heading); font-size: 1.1rem; color: var(--text-color); margin-bottom: 10px;">Tidak Ada Produk Ditemukan</p>
                            <p style="font-size: 0.9rem; color: #666;">Coba hapus beberapa filter atau gunakan kata kunci yang berbeda.</p>
                            <a href="{{ route('products.index') }}" style="display: inline-block; margin-top: 15px; padding: 10px 20px; background: var(--accent-color); color: #fff; text-decoration: none; border-radius: 6px; font-weight: 500;">Hapus Filter</a>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div style="margin-top: 30px; display: flex; justify-content: center;">
                    {{ $products->links('pagination::bootstrap-4') }}
                </div>
            </div>

        </div>
    </div>
</main>
@endsection
