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
                <a href="{{ route('seller.products.index') }}" class="active">Produk Saya</a>
                <a href="{{ route('seller.orders.index') }}">Pesanan Masuk</a>
                <form action="{{ route('logout') }}" method="POST" style="margin-top: auto;">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="account-content">
            <div class="content-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 class="section-title">Produk Saya</h2>
                <a href="{{ route('seller.products.create') }}" class="primary-btn" style="text-decoration: none; display: inline-block;">+ Tambah Produk</a>
            </div>

            @if(session('success'))
                <div class="alert alert-success" style="padding: 1rem; background: var(--pixel-green); color: white; margin-bottom: 1rem; border: 4px solid var(--pixel-dark);">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="border: 2px solid var(--pixel-dark); padding: 10px; background: var(--pixel-light);">Produk</th>
                            <th style="border: 2px solid var(--pixel-dark); padding: 10px; background: var(--pixel-light);">Harga</th>
                            <th style="border: 2px solid var(--pixel-dark); padding: 10px; background: var(--pixel-light);">Stok</th>
                            <th style="border: 2px solid var(--pixel-dark); padding: 10px; background: var(--pixel-light);">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td style="border: 2px solid var(--pixel-dark); padding: 10px; display: flex; align-items: center; gap: 10px;">
                                    <img src="{{ asset($product->images[0]) }}" alt="{{ $product->title_id }}" style="width: 50px; height: 50px; object-fit: cover; border: 2px solid var(--pixel-dark);">
                                    {{ $product->title_id }}
                                </td>
                                <td style="border: 2px solid var(--pixel-dark); padding: 10px;">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td style="border: 2px solid var(--pixel-dark); padding: 10px;">{{ $product->stock }}</td>
                                <td style="border: 2px solid var(--pixel-dark); padding: 10px;">
                                    <a href="{{ route('seller.products.edit', $product) }}" class="btn btn-sm" style="background: var(--pixel-yellow); padding: 5px 10px; border: 2px solid var(--pixel-dark); text-decoration: none; color: var(--pixel-dark);">Edit</a>
                                    <form action="{{ route('seller.products.destroy', $product) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Hapus produk ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm" style="background: var(--pixel-red); padding: 5px 10px; border: 2px solid var(--pixel-dark); color: white; cursor: pointer;">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="border: 2px solid var(--pixel-dark); padding: 20px; text-align: center;">Toko Anda belum memiliki produk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection
