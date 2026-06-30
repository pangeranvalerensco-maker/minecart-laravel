@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')
<main>
    <div class="container page-title" style="margin-top: 2rem;">
        <h1 data-translate-key="order-history">Riwayat Pesanan</h1>
    </div>

    <section style="padding-bottom: 3rem;">
        <div class="container" style="display: flex; gap: 30px; flex-wrap: wrap;">
            
            <div style="width: 250px; flex-shrink: 0;">
                <div style="background-color: var(--card-bg); border: 1px solid var(--subtle-border-color); border-radius: 8px; padding: 20px;">
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px;">
                        <li><a href="{{ route('account.index') }}" style="color: var(--text-color); font-weight: 500; text-decoration: none;">Profil Saya</a></li>
                        <li><a href="{{ route('account.orders') }}" style="color: var(--accent-color); font-weight: 500; text-decoration: none;" data-translate-key="order-history">Riwayat Pesanan</a></li>
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
                <div style="background-color: var(--card-bg); border: 1px solid var(--subtle-border-color); border-radius: 12px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                    <h2 style="font-size: 1.2rem; font-weight: 600; color: var(--heading-color); margin: 0 0 20px 0; border-bottom: 1px solid var(--subtle-border-color); padding-bottom: 15px;" data-translate-key="order-history-title">Riwayat Pesanan Anda</h2>
                    
                    @if($orders->isEmpty())
                        <div style="text-align: center; padding: 2rem;">
                            <p>Anda belum pernah melakukan pemesanan.</p>
                            <a href="{{ route('products.index') }}" class="primary-btn" style="display: inline-block; margin-top: 10px; text-decoration: none;">Mulai Belanja</a>
                        </div>
                    @else
                        @foreach($orders as $order)
                            @php
                                $subtotalProduk = $order->items->sum('subtotal');
                                $biayaKirim = ($order->total ?? 0) - $subtotalProduk;
                            @endphp
                            <div style="border: 1px solid var(--subtle-border-color); border-radius: 8px; margin-bottom: 20px; padding: 20px; transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease; box-shadow: 0 2px 5px rgba(0,0,0,0.02); cursor: default;" onmouseover="this.style.boxShadow='0 10px 25px rgba(0,0,0,0.08)'; this.style.borderColor='var(--accent-color)'; this.style.transform='translateY(-3px)';" onmouseout="this.style.boxShadow='0 2px 5px rgba(0,0,0,0.02)'; this.style.borderColor='var(--subtle-border-color)'; this.style.transform='none';">
                                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--subtle-border-color); padding-bottom: 12px; margin-bottom: 15px;">
                                    <div>
                                        <span style="font-weight: bold; color: var(--heading-color);">Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                                        <span style="font-size: 0.85rem; color: #888; margin-left: 10px;">{{ $order->created_at->format('d M Y, H:i') }}</span>
                                    </div>
                                    <div>
                                        <span style="padding: 6px 12px; border-radius: 6px; font-size: 0.8rem; background: var(--subtle-border-color); color: var(--heading-color); font-weight: bold;">{{ $order->status ?? 'Menunggu Pembayaran' }}</span>
                                    </div>
                                </div>

                                @foreach($order->items as $item)
                                <div style="display: flex; gap: 15px; margin-bottom: 15px; align-items: center;">
                                    <div style="position: relative;">
                                        <img src="{{ asset($item->product->images[0] ?? 'assets/products/product-placeholder.jpg') }}" alt="product" style="width: 65px; height: 65px; object-fit: cover; border-radius: 6px; border: 1px solid var(--subtle-border-color);">
                                        <span style="position: absolute; top: -6px; right: -6px; background: var(--subtle-border-color); color: var(--text-color); font-size: 0.7rem; font-weight: bold; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">{{ $item->quantity }}</span>
                                    </div>
                                    <div style="flex: 1;">
                                        <div style="font-weight: 600; color: var(--heading-color); font-size: 0.95rem; margin-bottom: 2px;" data-title-id="{{ $item->product->title_id }}" data-title-en="{{ $item->product->title_en }}">{{ $item->product_name }}</div>
                                        <div style="font-size: 0.85rem; color: var(--text-color);">Rp {{ number_format($item->price, 0, ',', '.') }} <span style="opacity:0.6;">/ item</span></div>
                                        @if($item->tracking_number)
                                            <div style="margin-top: 8px; font-size: 0.8rem; color: var(--text-color); background: var(--body-bg); padding: 6px 10px; border-radius: 6px; display: inline-block; border: 1px solid var(--subtle-border-color);">
                                                Kurir: <strong>{{ strtoupper($item->shipping_courier ?? '-') }}</strong> | Resi: <strong>{{ $item->tracking_number }}</strong>
                                                <span style="margin-left: 5px; color: #10b981; font-weight: bold;">(Dikirim)</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div style="font-weight: bold; color: var(--heading-color);">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </div>
                                    @if($order->status === 'completed')
                                        <div style="margin-left: 15px;">
                                            @if($item->review)
                                                <span style="font-size: 0.85rem; color: #f59e0b; font-weight: bold; display: flex; align-items: center; gap: 4px;"><span>⭐</span> Dinilai ({{ $item->review->rating }}/5)</span>
                                            @else
                                                <a href="{{ route('reviews.create', $item) }}" style="background: transparent; color: var(--accent-color); border: 1px solid var(--accent-color); padding: 6px 12px; border-radius: 4px; font-size: 0.8rem; text-decoration: none; display: inline-block; font-weight: 600; transition: all 0.2s;" onmouseover="this.style.background='var(--accent-color)'; this.style.color='#fff';" onmouseout="this.style.background='transparent'; this.style.color='var(--accent-color)';">Beri Ulasan</a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                @endforeach

                                <div style="display: flex; justify-content: space-between; align-items: flex-end; border-top: 1px solid var(--subtle-border-color); padding-top: 15px; margin-top: 5px;">
                                    <div>
                                        <div style="font-size: 0.85rem; color: var(--text-color); margin-bottom: 4px; display: flex; gap: 10px;">
                                            <span style="width: 120px;" data-translate-key="order-subtotal">Subtotal Produk</span>
                                            <span style="font-weight: 600; color: var(--heading-color);">Rp {{ number_format($subtotalProduk, 0, ',', '.') }}</span>
                                        </div>
                                        <div style="font-size: 0.85rem; color: var(--text-color); margin-bottom: 8px; display: flex; gap: 10px;">
                                            <span style="width: 120px;" data-translate-key="order-shipping">Biaya Pengiriman</span>
                                            <span style="font-weight: 600; color: var(--heading-color);">Rp {{ number_format($biayaKirim, 0, ',', '.') }}</span>
                                        </div>
                                        <div style="font-size: 0.95rem; display: flex; gap: 10px; align-items: center;">
                                            <span style="width: 120px; font-weight: 500;" data-translate-key="order-grand-total">Total Pembayaran</span>
                                            <strong style="color: var(--accent-color); font-size: 1.25rem;">Rp {{ number_format($order->total ?? 0, 0, ',', '.') }}</strong>
                                        </div>
                                    </div>

                                    @if($order->status == 'pending')
                                        @if($order->payment_method === 'xendit' && $order->xendit_invoice_url)
                                            <a href="{{ $order->xendit_invoice_url }}" class="primary-btn" style="padding: 6px 12px; font-size: 0.9rem; text-decoration: none;">Bayar Sekarang</a>
                                        @else
                                            <button class="primary-btn" style="padding: 6px 12px; font-size: 0.9rem;">Bayar Sekarang</button>
                                        @endif
                                    @elseif($order->payment_method === 'manual_transfer' && $order->payment_status === 'pending')
                                        <a href="{{ route('checkout.upload_proof_form', $order->id) }}" class="primary-btn" style="padding: 6px 12px; font-size: 0.9rem; text-decoration: none;">Upload Bukti TF</a>
                                    @elseif($order->payment_method === 'manual_transfer' && $order->payment_status === 'pending_verification')
                                        <span style="color: #d97706; font-weight: bold; font-size: 0.9rem;">Menunggu Verifikasi</span>
                                    @elseif(in_array($order->status, ['processing', 'shipped']))
                                        <form action="{{ route('account.orders.complete', $order) }}" method="POST" style="margin:0;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="primary-btn" style="padding: 6px 12px; font-size: 0.9rem; background: #2a9d8f;">Selesaikan Pesanan</button>
                                        </form>
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
