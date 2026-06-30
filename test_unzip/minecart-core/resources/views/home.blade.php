@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div style="background-color: var(--body-bg); padding-bottom: 40px;">
    
    <!-- Hero Section / Carousel -->
    <section class="home-carousel" style="margin-bottom: 20px;">
        <div class="carousel-container">
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

        <div class="hero-overlay"></div>

        <div class="hero-content">
            <h1 data-translate-key="hero-title">Koleksi Terbaru Musim Ini</h1>
            <p data-translate-key="hero-subtitle">Temukan gaya terbaik Anda dengan produk pilihan berkualitas tinggi.</p>
            <a href="{{ route('products.index') }}" class="cta-button" data-translate-key="hero-cta" style="background: var(--accent-color); color: var(--accent-text-color);">Lihat Semua Produk</a>
        </div>
        <button id="prevBtn" class="carousel-btn prev">&#10094;</button>
        <button id="nextBtn" class="carousel-btn next">&#10095;</button>
    </section>

    <div class="container">
        
        <!-- Shopee Style Circular Categories Menu -->
        <div style="background: var(--card-bg); padding: 20px; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.05); margin-bottom: 20px; transition: background 0.3s;">
            <div style="display: flex; justify-content: space-between; align-items: center; overflow-x: auto; padding-bottom: 10px;">
                
                <a href="#" style="text-align: center; text-decoration: none; min-width: 100px; color: var(--text-color);">
                    <div style="width: 50px; height: 50px; border-radius: 16px; background: #fff5f5; color: #e63946; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 10px; border: 1px solid #fecdd3;">
                        🛍️
                    </div>
                    <span style="font-size: 0.8rem; font-weight: 500;">MineCart Mall</span>
                </a>
                
                <a href="#" style="text-align: center; text-decoration: none; min-width: 100px; color: var(--text-color);">
                    <div style="width: 50px; height: 50px; border-radius: 16px; background: #fffbeb; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 10px; border: 1px solid #fde68a;">
                        ⚡
                    </div>
                    <span style="font-size: 0.8rem; font-weight: 500;">Flash Sale</span>
                </a>
                
                <a href="#" style="text-align: center; text-decoration: none; min-width: 100px; color: var(--text-color);">
                    <div style="width: 50px; height: 50px; border-radius: 16px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 10px; border: 1px solid #a7f3d0;">
                        🚚
                    </div>
                    <span style="font-size: 0.8rem; font-weight: 500;">Gratis Ongkir</span>
                </a>

                <a href="#" style="text-align: center; text-decoration: none; min-width: 100px; color: var(--text-color);">
                    <div style="width: 50px; height: 50px; border-radius: 16px; background: #f0fdf4; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 10px; border: 1px solid #bbf7d0;">
                        ☪️
                    </div>
                    <span style="font-size: 0.8rem; font-weight: 500;">Barokah</span>
                </a>

                <a href="#" style="text-align: center; text-decoration: none; min-width: 100px; color: var(--text-color);">
                    <div style="width: 50px; height: 50px; border-radius: 16px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 10px; border: 1px solid #bfdbfe;">
                        📱
                    </div>
                    <span style="font-size: 0.8rem; font-weight: 500;">Pulsa & Tagihan</span>
                </a>
                
                <a href="#" style="text-align: center; text-decoration: none; min-width: 100px; color: var(--text-color);">
                    <div style="width: 50px; height: 50px; border-radius: 16px; background: #f8fafc; color: #475569; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 10px; border: 1px solid #e2e8f0;">
                        🛒
                    </div>
                    <span style="font-size: 0.8rem; font-weight: 500;">Supermarket</span>
                </a>
                
                <a href="#" style="text-align: center; text-decoration: none; min-width: 100px; color: var(--text-color);">
                    <div style="width: 50px; height: 50px; border-radius: 16px; background: #faf5ff; color: #9333ea; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 10px; border: 1px solid #e9d5ff;">
                        🎟️
                    </div>
                    <span style="font-size: 0.8rem; font-weight: 500;">Semua Promo</span>
                </a>
            </div>
        </div>

        <!-- Flash Sale Section -->
        @if($flashSaleProducts->count() > 0)
        <div style="background: linear-gradient(135deg, #e63946, #b91c1c); border-radius: 8px; padding: 20px; margin-bottom: 20px; color: white;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <h2 style="font-size: 1.5rem; font-weight: 800; margin: 0; font-style: italic;">⚡ FLASH SALE</h2>
                    <div style="display: flex; gap: 5px; align-items: center; font-weight: bold; font-family: monospace; font-size: 1.1rem;">
                        <span style="background: black; padding: 4px 8px; border-radius: 4px;" id="fs-hours">00</span>
                        <span>:</span>
                        <span style="background: black; padding: 4px 8px; border-radius: 4px;" id="fs-mins">00</span>
                        <span>:</span>
                        <span style="background: black; padding: 4px 8px; border-radius: 4px;" id="fs-secs">00</span>
                    </div>
                </div>
                <a href="{{ route('products.index') }}" style="color: white; font-size: 0.9rem; font-weight: 500; text-decoration: none;">Lihat Semua ></a>
            </div>
            
            <div style="display: flex; gap: 15px; overflow-x: auto; padding-bottom: 10px;">
                @foreach($flashSaleProducts as $fsProduct)
                    @php
                        $discount = $fsProduct->price > 0 ? round((($fsProduct->price - $fsProduct->flash_sale_price) / $fsProduct->price) * 100) : 0;
                        // For countdown, assuming they all end at the same time or we pick the first one's end time
                        if(!isset($fsEndTime) && $fsProduct->flash_sale_end) {
                            $fsEndTime = $fsProduct->flash_sale_end->timestamp * 1000;
                        }
                    @endphp
                    <a href="{{ route('products.show', $fsProduct) }}" style="min-width: 160px; max-width: 160px; background: white; border-radius: 8px; overflow: hidden; text-decoration: none; position: relative; color: var(--text-color); display: block;">
                        <div style="position: absolute; top: 0; right: 0; background: #fbbf24; color: #854d0e; font-size: 0.75rem; font-weight: bold; padding: 3px 8px; border-bottom-left-radius: 8px; z-index: 2;">
                            -{{ $discount }}%
                        </div>
                        <div style="height: 160px; position: relative;">
                            <img src="{{ $fsProduct->image_url }}" alt="{{ $fsProduct->title_id }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div style="padding: 10px;">
                            <div style="color: #e63946; font-weight: 800; font-size: 1.1rem; margin-bottom: 5px;">
                                Rp{{ number_format($fsProduct->flash_sale_price, 0, ',', '.') }}
                            </div>
                            <div style="color: #94a3b8; text-decoration: line-through; font-size: 0.8rem; margin-bottom: 8px;">
                                Rp{{ number_format($fsProduct->price, 0, ',', '.') }}
                            </div>
                            <div style="background: #fee2e2; border-radius: 10px; height: 14px; position: relative; overflow: hidden;">
                                @php
                                    // Just a simulated sold percentage based on stock
                                    $soldPct = rand(30, 95);
                                @endphp
                                <div style="background: linear-gradient(90deg, #ef4444, #f87171); width: {{ $soldPct }}%; height: 100%; border-radius: 10px;"></div>
                                <span style="position: absolute; top: 0; left: 0; width: 100%; text-align: center; font-size: 0.6rem; color: #7f1d1d; font-weight: bold; line-height: 14px;">SEGERA HABIS</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        
        @if(isset($fsEndTime))
        <script>
            const fsEndTime = {{ $fsEndTime }};
            const updateFlashSale = () => {
                const now = new Date().getTime();
                const diff = fsEndTime - now;
                if(diff > 0) {
                    const h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    const s = Math.floor((diff % (1000 * 60)) / 1000);
                    document.getElementById('fs-hours').textContent = h.toString().padStart(2, '0');
                    document.getElementById('fs-mins').textContent = m.toString().padStart(2, '0');
                    document.getElementById('fs-secs').textContent = s.toString().padStart(2, '0');
                }
            };
            setInterval(updateFlashSale, 1000);
            updateFlashSale();
        </script>
        @endif
        @endif

        <!-- Main Content with Sidebar -->
        <div style="display: flex; gap: 20px; align-items: flex-start;">
            
            <!-- Sidebar Kategori -->
            <aside style="width: 220px; flex-shrink: 0; background: var(--card-bg); border-radius: 8px; padding: 20px; box-shadow: 0 1px 4px rgba(0,0,0,0.05); position: sticky; top: 90px; transition: background 0.3s;">
                <h3 style="font-size: 1rem; margin-bottom: 15px; border-bottom: 2px solid var(--subtle-border-color); padding-bottom: 10px; font-weight: 600; color: var(--text-color);" data-translate-key="filter-category">Kategori</h3>
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 5px;">
                    @foreach($categories as $cat)
                        <li>
                            <a href="{{ route('products.index', ['category' => $cat->slug]) }}" style="text-decoration: none; color: var(--text-color); font-size: 0.9rem; display: block; padding: 8px 10px; border-radius: 4px; transition: background 0.2s;" onmouseover="this.style.background='var(--subtle-border-color)'; this.style.color='var(--accent-color)'" onmouseout="this.style.background='transparent'; this.style.color='var(--text-color)'">
                                {{ $cat->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </aside>

            <!-- Product Grid -->
            <div style="flex-grow: 1;">
                <div style="background: var(--card-bg); padding: 20px; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.05); transition: background 0.3s;">
                    <h2 style="font-size: 1.2rem; margin-bottom: 20px; color: #e63946; font-weight: 700;">REKOMENDASI UNTUK ANDA</h2>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 15px;">
                        @forelse ($recommendedProducts as $product)
                            <article class="product-card" style="background: var(--card-bg); border: 1px solid var(--subtle-border-color); border-radius: 8px; overflow: hidden; position: relative; display: flex; flex-direction: column;" onclick="window.location='{{ route('products.show', $product) }}'" style="cursor: pointer; transition: background 0.3s, transform 0.2s ease, border-color 0.2s ease;">
                                
                                <!-- Badges -->
                                <div style="position: absolute; top: 8px; left: -4px; z-index: 10; display: flex; flex-direction: column; gap: 4px;">
                                    <span style="background: #fde047; color: #854d0e; font-size: 0.65rem; font-weight: bold; padding: 2px 8px; border-radius: 0 4px 4px 0; box-shadow: 1px 1px 2px rgba(0,0,0,0.1);">Mall</span>
                                    <span style="background: #a7f3d0; color: #065f46; font-size: 0.65rem; font-weight: bold; padding: 2px 8px; border-radius: 0 4px 4px 0; box-shadow: 1px 1px 2px rgba(0,0,0,0.1);">Gratis Ongkir</span>
                                </div>

                                <div style="display: block; position: relative; padding-top: 100%; overflow: hidden;">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->title_id }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                
                                <div style="padding: 10px; display: flex; flex-direction: column; flex-grow: 1;">
                                    <h3 style="margin: 0 0 5px 0; font-size: 0.85rem; font-weight: 500; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 34px; line-height: 1.2;">
                                        <span style="color: var(--text-color); text-decoration: none;" data-title-id="{{ $product->title_id }}" data-title-en="{{ $product->title_en }}">
                                            {{ $product->title_id }}
                                        </span>
                                    </h3>
                                    
                                    <div style="font-size: 1.1rem; font-weight: bold; color: var(--accent-color); margin-bottom: 5px;">
                                        Rp{{ number_format($product->price, 0, ',', '.') }}
                                    </div>
                                    
                                    <div style="display: flex; align-items: center; justify-content: space-between; font-size: 0.7rem; color: #94a3b8; margin-bottom: 10px;">
                                        <div style="display: flex; align-items: center; color: #fbbf24;">
                                            ★ 5.0
                                        </div>
                                        <div>
                                            {{ rand(10, 500) }} Terjual
                                        </div>
                                    </div>
                                    
                                    <!-- City/Location simulate -->
                                    <div style="font-size: 0.75rem; color: var(--text-color); display: flex; align-items: center; gap: 4px; margin-bottom: 10px; opacity: 0.8;">
                                        📍 {{ $product->seller->city ?? 'Jakarta Selatan' }}
                                    </div>

                                    <div style="margin-top: auto;" onclick="event.stopPropagation();">
                                        <form action="{{ route('cart.add', $product) }}" method="POST" class="js-add-to-cart-form" style="margin: 0;">
                                            @csrf
                                            <button type="submit" {{ $product->stock <= 0 ? 'disabled' : '' }} class="buy-btn" style="width: 100%; background: {{ $product->stock <= 0 ? 'var(--subtle-border-color)' : 'var(--accent-color)' }}; color: {{ $product->stock <= 0 ? 'var(--text-color)' : 'var(--accent-text-color)' }}; border: none; padding: 6px; border-radius: 4px; font-weight: 600; font-size: 0.8rem; cursor: {{ $product->stock <= 0 ? 'not-allowed' : 'pointer' }}; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                                {{ $product->stock <= 0 ? 'Habis' : 'Tambah' }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div style="grid-column: 1 / -1; text-align: center; padding: 40px 20px;">
                                <p style="font-size: 1rem; color: var(--text-color);">Belum ada produk rekomendasi.</p>
                            </div>
                        @endforelse
                    </div>

                    <div style="text-align: center; margin-top: 30px;">
                        <a href="{{ route('products.index') }}" style="display: inline-block; padding: 10px 40px; background: #fff; color: var(--primary-color); border: 1px solid var(--primary-color); border-radius: 4px; font-weight: 500; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='var(--primary-color)'; this.style.color='#fff'" onmouseout="this.style.background='#fff'; this.style.color='var(--primary-color)'">
                            Muat Lebih Banyak
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="cs-popup" class="cs-popup hidden-element">
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
