@php
    $headerCart = session()->get('cart', []);
    $previewItems = array_slice($headerCart, 0, 3, true);
    $previewProducts = \App\Models\Product::whereIn('id', array_keys($previewItems))->get()->keyBy('id');
@endphp
@forelse($previewItems as $productId => $item)
    @if(isset($previewProducts[$productId]))
    <a href="{{ route('products.show', $previewProducts[$productId]) }}" class="cart-preview-item" style="display: flex; gap: 10px; align-items: center; padding: 10px; border-bottom: 1px solid var(--subtle-border-color); text-decoration: none; color: inherit; transition: background 0.2s;" onmouseover="this.style.background='var(--body-bg)'" onmouseout="this.style.background='transparent'">
        <img src="{{ $previewProducts[$productId]->image_url }}" alt="{{ $previewProducts[$productId]->title_id }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
        <div class="cart-preview-details" style="flex-grow: 1;">
            <p class="cart-preview-name product-title" data-title-id="{{ $previewProducts[$productId]->title_id }}" data-title-en="{{ $previewProducts[$productId]->title_en }}" style="margin: 0; font-size: 0.9rem; font-weight: 500;">{{ $previewProducts[$productId]->title_id }}</p>
            <p class="cart-preview-price" style="margin: 5px 0 0; font-size: 0.85rem; color: var(--accent-color);">Rp {{ number_format($previewProducts[$productId]->price, 0, ',', '.') }} x {{ $item['quantity'] }}</p>
        </div>
    </a>
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
