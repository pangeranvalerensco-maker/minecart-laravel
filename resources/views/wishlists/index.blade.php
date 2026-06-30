@extends('layouts.app')

@section('title', 'Wishlist Saya')

@section('content')
<main>
    <div class="container page-title" style="margin-top: 2rem; margin-bottom: 2rem;">
        <h1>Wishlist Saya</h1>
        <p style="color: var(--text-color);">Produk-produk favorit Anda yang disimpan untuk nanti.</p>
    </div>

    <section class="wishlist-section" style="padding-bottom: 4rem;">
        <div class="container">
            @if ($wishlists->isEmpty())
                <div style="text-align: center; padding: 50px 0; background: var(--card-bg); border-radius: 16px; border: 1px solid var(--subtle-border-color);">
                    <div style="font-size: 3rem; margin-bottom: 15px;">❤️</div>
                    <h2 style="font-size: 1.25rem; margin-bottom: 10px; color: var(--heading-color);">Wishlist Anda Kosong</h2>
                    <p style="color: var(--text-color); margin-bottom: 20px;">Anda belum menambahkan produk apa pun ke daftar keinginan.</p>
                    <a href="{{ route('products.index') }}" class="cta-button" style="display: inline-block;">Mulai Belanja</a>
                </div>
            @else
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 25px;">
                    @foreach ($wishlists as $wishlist)
                        @php
                            $product = $wishlist->product;
                        @endphp
                        <a href="{{ route('products.show', $product->id) }}" class="product-card" style="text-decoration: none; display: block; position: relative; background: var(--card-bg); border: 1px solid var(--subtle-border-color); border-radius: 12px; overflow: hidden; transition: transform 0.2s, box-shadow 0.2s;">
                            <div style="height: 200px; overflow: hidden;">
                                <img src="{{ asset($product->images[0] ?? 'assets/logo-minecart.png') }}" alt="{{ $product->title_id }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;">
                            </div>
                            <div style="padding: 15px;">
                                <h3 style="font-size: 1.1rem; margin-bottom: 8px; color: var(--heading-color); font-weight: 600;">{{ $product->title_id }}</h3>
                                <p style="font-weight: 700; color: var(--accent-color); font-size: 1.1rem; margin-bottom: 10px;">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                
                                <form action="{{ route('wishlists.toggle', $product->id) }}" method="POST" style="position: absolute; top: 10px; right: 10px;">
                                    @csrf
                                    <button type="submit" style="background: white; border: none; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                                        <span style="color: red; font-size: 1.2rem;">❤️</span>
                                    </button>
                                </form>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</main>
@endsection
