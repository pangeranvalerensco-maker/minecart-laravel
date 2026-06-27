@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')
<main>
    <div class="container page-title" style="margin-top: 2rem;">
        <h1>Riwayat Pesanan</h1>
    </div>

    <section style="padding-bottom: 3rem;">
        <div class="container" style="display: flex; gap: 30px; flex-wrap: wrap;">
            
            <div style="width: 250px; flex-shrink: 0;">
                <div style="background-color: var(--card-bg); border: 1px solid var(--subtle-border-color); border-radius: 8px; padding: 20px;">
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px;">
                        <li><a href="{{ route('account.index') }}" style="color: var(--text-color); font-weight: 500; text-decoration: none;">Profil Saya</a></li>
                        <li><a href="{{ route('account.orders') }}" style="color: var(--accent-color); font-weight: 500; text-decoration: none;">Riwayat Pesanan</a></li>
                        <li>
                            @if(auth()->user()->is_seller)
                                <a href="{{ route('seller.products.index') }}" style="color: var(--text-color); font-weight: 500; text-decoration: none;">Toko Saya</a>
                            @else
                                <a href="{{ route('store.create') }}" style="color: var(--text-color); font-weight: 500; text-decoration: none;">Buka Toko</a>
                            @endif
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" style="background: none; border: none; color: #e63946; cursor: pointer; padding: 0; font-family: inherit; font-size: 1rem; text-decoration: underline;">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <div style="flex: 1; min-width: 300px;">
                <div style="background-color: var(--card-bg); border: 1px solid var(--subtle-border-color); border-radius: 8px; padding: 20px;">
                    <h2 style="font-family: var(--font-heading); font-size: 1.1rem; color: var(--heading-color); margin: 0 0 15px 0; border-bottom: 1px solid var(--subtle-border-color); padding-bottom: 10px;">Riwayat Pesanan Anda</h2>
                    
                    @if($orders->isEmpty())
                        <div style="text-align: center; padding: 2rem;">
                            <p>Anda belum pernah melakukan pemesanan.</p>
                            <a href="{{ route('products.index') }}" class="primary-btn" style="display: inline-block; margin-top: 10px; text-decoration: none;">Mulai Belanja</a>
                        </div>
                    @else
                        @foreach($orders as $order)
                            <div style="border: 1px solid var(--subtle-border-color); border-radius: 6px; margin-bottom: 15px; padding: 15px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--subtle-border-color); padding-bottom: 10px; margin-bottom: 10px;">
                                    <div>
                                        <span style="font-weight: bold;">Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                                        <span style="font-size: 0.85rem; color: #666; margin-left: 10px;">{{ $order->created_at->format('d M Y, H:i') }}</span>
                                    </div>
                                    <div>
                                        <span style="padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; background: var(--pixel-yellow); color: var(--pixel-dark); font-weight: bold;">{{ $order->status ?? 'Menunggu Pembayaran' }}</span>
                                    </div>
                                </div>

                                @foreach($order->items as $item)
                                <div style="display: flex; gap: 15px; margin-bottom: 10px;">
                                    <img src="{{ asset($item->product->images[0] ?? 'assets/products/product-placeholder.jpg') }}" alt="product" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px; border: 1px solid var(--subtle-border-color);">
                                    <div style="flex: 1;">
                                        <div style="font-weight: 500;">{{ $item->product_name }}</div>
                                        <div style="font-size: 0.85rem; color: #666;">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                                    </div>
                                    <div style="font-weight: bold; align-self: center;">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </div>
                                </div>
                                @endforeach

                                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--subtle-border-color); padding-top: 10px; margin-top: 10px;">
                                    <div style="font-size: 0.9rem;">
                                        Total Harga: <strong style="color: var(--accent-color); font-size: 1.1rem;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                                    </div>
                                    @if($order->status == 'pending')
                                        <!-- Midtrans payment button placeholder -->
                                        <button class="primary-btn" style="padding: 6px 12px; font-size: 0.9rem;">Bayar Sekarang</button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
