@extends('layouts.app')

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
                <a href="{{ route('account.index') }}">Profil Saya</a>
                <a href="{{ route('seller.products.index') }}">Produk Saya</a>
                <a href="{{ route('seller.orders.index') }}" class="active">Pesanan Masuk</a>
                <form action="{{ route('logout') }}" method="POST" style="margin-top: auto;">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="account-content">
            <h2 class="section-title">Pesanan Masuk</h2>

            <div class="table-responsive">
                <table class="table" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="border: 2px solid var(--pixel-dark); padding: 10px; background: var(--pixel-light);">Tanggal</th>
                            <th style="border: 2px solid var(--pixel-dark); padding: 10px; background: var(--pixel-light);">Order ID</th>
                            <th style="border: 2px solid var(--pixel-dark); padding: 10px; background: var(--pixel-light);">Produk</th>
                            <th style="border: 2px solid var(--pixel-dark); padding: 10px; background: var(--pixel-light);">Qty</th>
                            <th style="border: 2px solid var(--pixel-dark); padding: 10px; background: var(--pixel-light);">Subtotal</th>
                            <th style="border: 2px solid var(--pixel-dark); padding: 10px; background: var(--pixel-light);">Pembeli</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orderItems as $item)
                            <tr>
                                <td style="border: 2px solid var(--pixel-dark); padding: 10px;">{{ $item->created_at->format('d M Y, H:i') }}</td>
                                <td style="border: 2px solid var(--pixel-dark); padding: 10px;">#{{ str_pad($item->order_id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td style="border: 2px solid var(--pixel-dark); padding: 10px;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <img src="{{ asset($item->product->images[0]) }}" alt="img" style="width: 40px; height: 40px; object-fit: cover; border: 1px solid var(--pixel-dark);">
                                        {{ $item->product_name }}
                                    </div>
                                </td>
                                <td style="border: 2px solid var(--pixel-dark); padding: 10px;">{{ $item->quantity }}</td>
                                <td style="border: 2px solid var(--pixel-dark); padding: 10px;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                <td style="border: 2px solid var(--pixel-dark); padding: 10px;">{{ $item->order->customer_name }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="border: 2px solid var(--pixel-dark); padding: 20px; text-align: center;">Belum ada pesanan masuk untuk produk Anda.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection
