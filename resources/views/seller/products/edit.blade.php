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
                <a href="#">Pesanan Masuk</a>
                <form action="{{ route('logout') }}" method="POST" style="margin-top: auto;">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="account-content">
            <h2 class="section-title">Edit Produk</h2>

            <form action="{{ route('seller.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="auth-form" style="max-width: 100%;">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label>Nama Produk (ID)</label>
                    <input type="text" name="title_id" class="form-control" required value="{{ old('title_id', $product->title_id) }}">
                </div>
                <div class="form-group">
                    <label>Nama Produk (EN)</label>
                    <input type="text" name="title_en" class="form-control" required value="{{ old('title_en', $product->title_en) }}">
                </div>
                
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id) == $category->id) ? 'selected' : '' }}>{{ $category->name_id }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Harga (Rp)</label>
                    <input type="number" name="price" class="form-control" required min="0" value="{{ old('price', $product->price) }}">
                </div>
                
                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" name="stock" class="form-control" required min="0" value="{{ old('stock', $product->stock) }}">
                </div>

                <div class="form-group">
                    <label>Deskripsi (ID)</label>
                    <textarea name="description_id" class="form-control" rows="4" required>{{ old('description_id', $product->description_id) }}</textarea>
                </div>
                <div class="form-group">
                    <label>Deskripsi (EN)</label>
                    <textarea name="description_en" class="form-control" rows="4" required>{{ old('description_en', $product->description_en) }}</textarea>
                </div>

                <div class="form-group">
                    <label>Gambar Produk (Biarkan kosong jika tidak ingin mengubah)</label>
                    <div style="margin-bottom: 10px;">
                        <img src="{{ asset($product->images[0]) }}" alt="Current Image" style="width: 100px; height: 100px; object-fit: cover; border: 2px solid var(--pixel-dark);">
                    </div>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" class="primary-btn">Perbarui Produk</button>
                    <a href="{{ route('seller.products.index') }}" class="secondary-btn" style="text-decoration: none; padding: 10px 20px; display: inline-block;">Batal</a>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
