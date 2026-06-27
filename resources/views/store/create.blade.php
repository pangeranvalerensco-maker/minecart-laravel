@extends('layouts.app')

@section('content')
<main class="main-content auth-page">
    <div class="auth-container">
        <h1 class="page-title">Buka Toko</h1>
        <p style="text-align: center; margin-bottom: 20px;">Jadilah penjual dan mulai tawarkan produk Anda di MineCart.</p>

        <form action="{{ route('store.store') }}" method="POST" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="store_name">Nama Toko</label>
                <input type="text" id="store_name" name="store_name" class="form-control" placeholder="Masukkan nama toko" required>
                @error('store_name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="submit-btn primary-btn">Buka Toko</button>
        </form>
    </div>
</main>
@endsection
