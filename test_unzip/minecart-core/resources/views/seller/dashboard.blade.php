@extends('layouts.app')

@section('title', 'Produk Saya')
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
                <a href="{{ route('seller.products.index') }}" class="active" data-translate-key="seller-products">Produk Saya</a>
                <a href="{{ route('seller.orders.index') }}" data-translate-key="seller-orders">Pesanan Masuk</a>
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
                <h2 class="section-title" style="margin: 0; font-size: 1.5rem; font-weight: 700; color: var(--heading-color);">Produk Saya</h2>
                <a href="{{ route('seller.products.create') }}" class="cta-button" style="text-decoration: none; padding: 10px 20px; font-weight: 600; border-radius: 8px;">+ Tambah Produk</a>
            </div>

            @if(session('success'))
                <div style="padding: 15px 20px; background-color: #d1fae5; color: #065f46; border-radius: 8px; margin-bottom: 20px; font-weight: 500;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="modern-table-container">
                @if($products->isEmpty())
                    <div style="text-align: center; padding: 60px 20px;">
                        <div style="font-size: 3rem; margin-bottom: 15px; opacity: 0.5;">📦</div>
                        <h3 style="margin: 0 0 10px 0; color: var(--heading-color);">Belum Ada Produk</h3>
                        <p style="color: var(--text-color); margin-bottom: 20px; opacity: 0.8;">Toko Anda masih kosong. Mulai jualan dengan menambahkan produk pertama Anda!</p>
                        <a href="{{ route('seller.products.create') }}" class="cta-button" style="text-decoration: none; padding: 10px 20px; font-weight: 600; border-radius: 8px;">Tambah Produk Sekarang</a>
                    </div>
                @else
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 15px;">
                                            <img src="{{ $product->image_url }}" alt="Product Image" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                            <div>
                                                <div style="font-weight: 600; color: var(--heading-color);">{{ $product->title_id }}</div>
                                                <div style="font-size: 0.85rem; color: var(--text-color); opacity: 0.7;">{{ $product->category->name_id ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="font-weight: 500; color: var(--text-color);">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td>
                                        <span style="background: var(--body-bg); padding: 4px 10px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; color: var(--text-color); border: 1px solid var(--subtle-border-color);">{{ $product->stock }}</span>
                                    </td>
                                    <td style="text-align: center;">
                                        <div style="display: flex; gap: 8px; justify-content: center;">
                                            <a href="{{ route('seller.products.edit', $product->id) }}" style="padding: 8px 15px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600; background: var(--body-bg); color: var(--accent-color); border: 1px solid var(--accent-color); transition: all 0.2s;" onmouseover="this.style.background='var(--accent-color)'; this.style.color='var(--accent-text-color)';" onmouseout="this.style.background='var(--body-bg)'; this.style.color='var(--accent-color)';">Edit</a>
                                            <form action="{{ route('seller.products.destroy', $product->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Hapus produk ini secara permanen?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="padding: 8px 15px; border-radius: 6px; border: 1px solid #ef4444; background: var(--body-bg); color: #ef4444; font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#ef4444'; this.style.color='#fff';" onmouseout="this.style.background='var(--body-bg)'; this.style.color='#ef4444';">Hapus</button>
                                            </form>
                                        </div>
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
