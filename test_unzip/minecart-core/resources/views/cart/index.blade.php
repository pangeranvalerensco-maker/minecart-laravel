@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<noscript>
    <style>
        .js-only-btn { display: none !important; }
    </style>
</noscript>
<main>
    <div class="container page-title" style="margin-top: 2rem;">
        <h1 data-translate-key="cart-title">Keranjang Belanja</h1>
    </div>

    <section class="cart-section" style="padding-bottom: 3rem;">
        <div class="container">
            @if (count($cartItems) > 0)
                <div id="cart-items-container">
                    <div class="cart-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <span data-translate-key="cart-items-label" style="font-weight: bold; font-family: var(--font-heading); font-size: 0.9rem;">Daftar Item</span>
                        <form action="{{ route('cart.clear') }}" method="POST" style="margin: 0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="remove-btn" style="background: #e63946; font-size: 0.85rem; padding: 6px 12px; border-radius: 4px; border: none; color: white; cursor: pointer;" data-translate-key="cart-clear-btn">
                                Kosongkan Keranjang
                            </button>
                        </form>
                    </div>

                    @foreach ($cartItems as $item)
                        <div class="cart-item" style="display: flex; gap: 20px; align-items: center; background-color: var(--card-bg); border: 1px solid var(--subtle-border-color); border-radius: 8px; padding: 15px; margin-bottom: 15px;">
                            <img src="{{ $item['product']->image_url }}" alt="{{ $item['product']->title_id }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                            <div class="cart-item-info" style="flex-grow: 1;">
                                <h3 style="margin: 0 0 5px 0; font-size: 1rem; color: var(--heading-color);">
                                    <a href="{{ route('products.show', $item['product']) }}" class="product-title-link product-title" data-title-id="{{ $item['product']->title_id }}" data-title-en="{{ $item['product']->title_en }}" style="text-decoration: none; color: inherit;">
                                        {{ $item['product']->title_id }}
                                    </a>
                                </h3>
                                <p class="price" style="font-weight: 500; color: var(--accent-color); margin-bottom: 5px;">Rp {{ number_format($item['product']->price, 0, ',', '.') }}</p>
                                <p style="font-size: 0.85rem; opacity: 0.8; margin: 0;">Subtotal: <span id="subtotal-{{ $item['product']->id }}" class="item-subtotal-value">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span></p>
                            </div>
                            <div class="cart-item-actions" style="display: flex; align-items: center; gap: 15px;">
                                <div class="quantity-controls" style="display: flex; align-items: center; gap: 8px; background: var(--body-bg); padding: 5px; border-radius: 6px; border: 1px solid var(--subtle-border-color);">
                                    <form action="{{ route('cart.update', $item['product']) }}" method="POST" style="margin: 0; display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="quantity" id="hidden-minus-{{ $item['product']->id }}" class="hidden-qty-minus" value="{{ $item['quantity'] - 1 }}">
                                        <button type="button" class="qty-btn qty-minus js-only-btn" data-product-id="{{ $item['product']->id }}" data-stock="{{ $item['product']->stock }}" {{ $item['quantity'] <= 1 ? 'disabled' : '' }} style="font-weight: bold; font-size: 1.1rem; color: var(--text-color); border: none; background: transparent; cursor: pointer; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">-</button>
                                        <noscript>
                                            <button type="submit" {{ $item['quantity'] <= 1 ? 'disabled' : '' }} style="font-weight: bold; font-size: 1.1rem; color: var(--text-color); border: none; background: transparent; cursor: pointer; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">-</button>
                                        </noscript>
                                    </form>
                                    
                                    <span id="quantity-{{ $item['product']->id }}" class="item-quantity-display" style="font-weight: 500; min-width: 20px; text-align: center;">{{ $item['quantity'] }}</span>
                                    
                                    <form action="{{ route('cart.update', $item['product']) }}" method="POST" style="margin: 0; display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="quantity" id="hidden-plus-{{ $item['product']->id }}" class="hidden-qty-plus" value="{{ $item['quantity'] + 1 }}">
                                        <button type="button" class="qty-btn qty-plus js-only-btn" data-product-id="{{ $item['product']->id }}" data-stock="{{ $item['product']->stock }}" {{ $item['quantity'] >= $item['product']->stock ? 'disabled' : '' }} style="font-weight: bold; font-size: 1.1rem; color: var(--text-color); border: none; background: transparent; cursor: pointer; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">+</button>
                                        <noscript>
                                            <button type="submit" {{ $item['quantity'] >= $item['product']->stock ? 'disabled' : '' }} style="font-weight: bold; font-size: 1.1rem; color: var(--text-color); border: none; background: transparent; cursor: pointer; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">+</button>
                                        </noscript>
                                    </form>
                                </div>
                                <form action="{{ route('cart.remove', $item['product']) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="remove-btn" style="background: #e63946; color: white; border: none; padding: 8px 12px; border-radius: 5px; cursor: pointer; transition: transform 0.2s;" data-translate-key="remove-item">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <aside class="cart-summary" style="width: 350px; flex-shrink: 0; position: sticky; top: 150px;">
                    <div style="background-color: var(--card-bg); border: 1px solid var(--subtle-border-color); border-radius: 8px; padding: 20px;">
                        <h2 data-translate-key="cart-summary-title" style="font-family: var(--font-heading); font-size: 0.95rem; color: var(--heading-color); margin: 0 0 15px 0; border-bottom: 1px solid var(--subtle-border-color); padding-bottom: 10px;">Ringkasan Belanja</h2>
                        <p style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.95rem;">
                            <span><span data-translate-key="summary-total-price">Total Harga (</span><span id="total-items">{{ $totalItems }}</span> <span data-translate-key="summary-items">Barang)</span></span>
                            <span style="font-weight: 500;" id="total-price-summary">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </p>
                        <p class="total" style="display: flex; justify-content: space-between; font-weight: bold; font-size: 1.1rem; border-top: 2px solid var(--subtle-border-color); padding-top: 10px; margin-top: 10px; color: var(--heading-color);">
                            <span data-translate-key="summary-total">Total</span>
                            <span style="color: var(--accent-color);" id="total-price">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </p>
                        <a href="{{ route('checkout.index') }}" class="cta-button" id="checkout-btn" style="width: 100%; margin-top: 20px; display: block; text-align: center; text-decoration: none;">
                            <span data-translate-key="checkout-btn-text">Beli</span> (<span class="total-items-count">{{ $totalItems }}</span>)
                        </a>
                    </div>
                </aside>
            @else
                <div class="empty-state" style="text-align: center; padding: 60px 20px; width: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                    <img src="{{ asset('assets/logo-minecart.png') }}" alt="Empty Cart" class="empty-cart-img" style="height: 120px; margin-bottom: 20px;">
                    <h2 style="font-family: var(--font-heading); font-size: 1.2rem; color: var(--text-color); margin-bottom: 15px;" data-translate-key="cart-empty-title">Keranjang Belanja Kosong</h2>
                    <p style="font-size: 0.95rem; color: var(--text-color); opacity: 0.7; margin-bottom: 25px;" data-translate-key="cart-empty-desc">Anda belum menambahkan produk apa pun ke keranjang belanja.</p>
                    <a href="{{ route('products.index') }}" class="cta-button" data-translate-key="hero-cta" style="text-decoration: none;">Lihat Semua Produk</a>
                </div>
            @endif
        </div>
    </section>
</main>
<script src="{{ asset('js/cart.js') }}"></script>
@endsection
