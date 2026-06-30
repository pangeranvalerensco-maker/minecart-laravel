@extends('layouts.app')

@section('title', 'Pesanan Masuk')
@section('content')
<main class="main-content">
    <div class="account-container">
        <!-- Sidebar -->
        <aside class="account-sidebar">
            <div class="user-info">
                <h3>Toko: {{ auth()->user()->store_name }}</h3>
                <p>{{ auth()->user()->email }}</p>
            </div>
            <nav class="account-nav">
                <a href="{{ route('account.index') }}" data-translate-key="my-profile">Profil Saya</a>
                <a href="{{ route('seller.products.index') }}" data-translate-key="seller-products">Produk Saya</a>
                <a href="{{ route('seller.orders.index') }}" class="active" data-translate-key="seller-orders">Pesanan Masuk</a>
                <a href="{{ route('seller.wallet.index') }}" data-translate-key="seller-wallet">Dompet & Penarikan</a>
                <a href="{{ route('seller.analytics.index') }}" data-translate-key="seller-analytics">Analitik Penjualan</a>
                <form action="{{ route('logout') }}" method="POST" style="margin-top: auto;">
                    @csrf
                    <button type="submit" class="logout-btn" data-translate-key="logout">Logout</button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="account-content">
            <div class="content-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                <h2 class="section-title" style="margin: 0; font-size: 1.5rem; font-weight: 700; color: var(--heading-color);">Pesanan Masuk</h2>
            </div>

            <div class="modern-table-container">
                @if($orderItems->isEmpty())
                    <div style="text-align: center; padding: 50px 0;">
                        <div style="font-size: 3rem; margin-bottom: 15px; opacity: 0.5;">📦</div>
                        <h3 style="color: var(--heading-color); margin-bottom: 10px; font-size: 1.2rem;">Belum ada pesanan</h3>
                        <p style="color: var(--text-color); font-size: 0.95rem; opacity: 0.8;">Produk Anda belum memiliki pesanan masuk. Terus promosikan toko Anda!</p>
                    </div>
                @else
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Produk</th>
                                <th style="text-align: center;">Jumlah</th>
                                <th>Total Harga</th>
                                <th>Status Pembayaran</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orderItems as $item)
                                <tr>
                                    <td style="font-weight: 600;">
                                        #{{ substr($item->order->id ?? '-', 0, 8) }}
                                    </td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <img src="{{ $item->product->image_url ?? '' }}" alt="Product" style="width: 40px; height: 40px; object-fit: cover; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                            <div style="font-weight: 600; font-size: 0.95rem; color: var(--heading-color);">{{ $item->product->title_id ?? 'Produk Dihapus' }}</div>
                                        </div>
                                    </td>
                                    <td style="text-align: center;">
                                        <span style="background: var(--body-bg); padding: 4px 10px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; color: var(--text-color); border: 1px solid var(--subtle-border-color);">{{ $item->quantity }}</span>
                                    </td>
                                    <td style="font-weight: 600; color: var(--accent-color);">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                    <td>
                                        @php
                                            $globalStatus = $item->order->status ?? 'pending';
                                            $paymentStatus = $item->order->payment_status ?? 'pending';
                                            $itemStatus = $item->status ?? 'processing';
                                            
                                            $displayStatus = $globalStatus === 'pending' ? 'Belum Dibayar' : 
                                                ($paymentStatus === 'pending_verification' ? 'Menunggu Verifikasi' :
                                                ($itemStatus === 'shipped' ? 'Dikirim' : 
                                                ($itemStatus === 'completed' ? 'Selesai' : 'Perlu Dikirim')));
                                            
                                            $bgColor = $displayStatus === 'Dikirim' || $displayStatus === 'Selesai' ? '#d1fae5' : ($displayStatus === 'Belum Dibayar' ? '#fee2e2' : '#fef3c7');
                                            $textColor = $displayStatus === 'Dikirim' || $displayStatus === 'Selesai' ? '#059669' : ($displayStatus === 'Belum Dibayar' ? '#dc2626' : '#d97706');
                                        @endphp
                                        <span style="background-color: {{ $bgColor }}; color: {{ $textColor }}; padding: 4px 10px; border-radius: 20px; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                                            {{ $displayStatus }}
                                        </span>
                                        
                                        @if($paymentStatus === 'pending_verification' && $item->order->payment_proof)
                                            <div style="margin-top: 10px;">
                                                <a href="{{ asset('storage/' . $item->order->payment_proof) }}" target="_blank" style="font-size: 0.85rem; color: var(--primary-color); text-decoration: underline;">Lihat Bukti TF</a>
                                                <form action="{{ route('seller.orders.verify_payment', $item->order) }}" method="POST" style="margin-top: 5px;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" style="background: #10b981; color: white; border: none; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; cursor: pointer;">Terima Pembayaran</button>
                                                </form>
                                            </div>
                                        @elseif($globalStatus !== 'pending' && $itemStatus === 'processing' && $paymentStatus !== 'pending_verification')
                                            <div style="margin-top: 15px;">
                                                <form action="{{ route('seller.orders.resi', $item) }}" method="POST" style="display:flex; gap: 8px;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="text" name="tracking_number" placeholder="Input Resi..." required style="width: 120px; padding: 6px 10px; border: 1px solid var(--subtle-border-color); border-radius: 6px; font-size: 0.85rem; background: var(--body-bg); color: var(--text-color);">
                                                    <button type="submit" style="background: var(--accent-color); color: var(--accent-text-color); border: none; padding: 6px 12px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; cursor: pointer;">Kirim</button>
                                                </form>
                                            </div>
                                        @elseif($item->tracking_number)
                                            <div style="margin-top: 8px; font-size: 0.85rem; color: var(--text-color); opacity: 0.8;">
                                                Kurir: {{ strtoupper($item->shipping_courier ?? '-') }}<br>
                                                Resi: <strong style="color: var(--heading-color);">{{ $item->tracking_number }}</strong>
                                            </div>
                                        @endif
                                    </td>
                                    <td style="color: var(--text-color); opacity: 0.8; font-size: 0.9rem;">
                                        {{ $item->created_at->format('d M Y, H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection
