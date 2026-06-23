@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<main>
    <div class="container page-title" style="margin-top: 2rem;">
        <h1>Checkout</h1>
    </div>

    <section class="cart-section" style="padding-bottom: 3rem;">
        <div class="container" style="display: flex; gap: 30px; flex-wrap: wrap;">
            {{-- Left Column: Cart Items --}}
            <div style="flex: 1; min-width: 300px;">
                <div style="background-color: var(--card-bg); border: 1px solid var(--subtle-border-color); border-radius: 8px; padding: 20px; margin-bottom: 20px;">
                    <h2 style="font-family: var(--font-heading); font-size: 0.95rem; color: var(--heading-color); margin: 0 0 15px 0; border-bottom: 1px solid var(--subtle-border-color); padding-bottom: 10px;">Ringkasan Pesanan</h2>
                    @foreach ($cartItems as $item)
                        <div style="display: flex; gap: 15px; align-items: center; padding: 12px 0; border-bottom: 1px solid var(--subtle-border-color);">
                            <img src="{{ asset($item['product']->images[0] ?? 'assets/logo-minecart.png') }}" alt="{{ $item['product']->title_id }}" style="width: 70px; height: 70px; object-fit: cover; border-radius: 6px;">
                            <div style="flex-grow: 1;">
                                <p style="margin: 0 0 4px 0; font-weight: 500; color: var(--heading-color); font-size: 0.95rem;">{{ $item['product']->title_id }}</p>
                                <p style="margin: 0; font-size: 0.85rem; opacity: 0.7;">{{ $item['quantity'] }} x Rp {{ number_format($item['product']->price, 0, ',', '.') }}</p>
                            </div>
                            <span style="font-weight: 500; color: var(--accent-color); white-space: nowrap;">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                        </div>
                    @endforeach

                    <div style="padding-top: 15px;">
                        <p style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 0.95rem;">
                            <span>Subtotal ({{ $totalItems }} Barang)</span>
                            <span style="font-weight: 500;">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </p>
                        <p style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 0.85rem; opacity: 0.7;">
                            <span>Ongkos Kirim</span>
                            <span>Dihitung saat pembayaran</span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Right Column: Checkout Form --}}
            <div style="width: 400px; flex-shrink: 0;">
                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                    <div style="background-color: var(--card-bg); border: 1px solid var(--subtle-border-color); border-radius: 8px; padding: 20px;">
                        <h2 style="font-family: var(--font-heading); font-size: 0.95rem; color: var(--heading-color); margin: 0 0 15px 0; border-bottom: 1px solid var(--subtle-border-color); padding-bottom: 10px;">Data Penerima</h2>

                        <div style="margin-bottom: 12px;">
                            <label for="fullname" style="display: block; font-size: 0.85rem; margin-bottom: 4px; font-weight: 500;">Nama Lengkap *</label>
                            <input type="text" id="fullname" name="fullname" value="{{ old('fullname', $user->name ?? '') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid var(--subtle-border-color); border-radius: 6px; background: var(--body-bg); color: var(--text-color); font-family: inherit; font-size: 0.9rem; box-sizing: border-box;">
                            @error('fullname') <p style="color: #e63946; font-size: 0.8rem; margin: 4px 0 0;">{{ $message }}</p> @enderror
                        </div>

                        <div style="margin-bottom: 12px;">
                            <label for="phone" style="display: block; font-size: 0.85rem; margin-bottom: 4px; font-weight: 500;">Nomor Telepon *</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone ?? '') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid var(--subtle-border-color); border-radius: 6px; background: var(--body-bg); color: var(--text-color); font-family: inherit; font-size: 0.9rem; box-sizing: border-box;">
                            @error('phone') <p style="color: #e63946; font-size: 0.8rem; margin: 4px 0 0;">{{ $message }}</p> @enderror
                        </div>

                        <div style="margin-bottom: 12px;">
                            <label for="address" style="display: block; font-size: 0.85rem; margin-bottom: 4px; font-weight: 500;">Alamat Lengkap *</label>
                            <textarea id="address" name="address" rows="3" required style="width: 100%; padding: 10px 12px; border: 1px solid var(--subtle-border-color); border-radius: 6px; background: var(--body-bg); color: var(--text-color); font-family: inherit; font-size: 0.9rem; resize: vertical; box-sizing: border-box;">{{ old('address', $user->address ?? '') }}</textarea>
                            @error('address') <p style="color: #e63946; font-size: 0.8rem; margin: 4px 0 0;">{{ $message }}</p> @enderror
                        </div>

                        <div style="display: flex; gap: 12px; margin-bottom: 12px;">
                            <div style="flex: 1;">
                                <label for="city" style="display: block; font-size: 0.85rem; margin-bottom: 4px; font-weight: 500;">Kota *</label>
                                <input type="text" id="city" name="city" value="{{ old('city', $user->city ?? '') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid var(--subtle-border-color); border-radius: 6px; background: var(--body-bg); color: var(--text-color); font-family: inherit; font-size: 0.9rem; box-sizing: border-box;">
                                @error('city') <p style="color: #e63946; font-size: 0.8rem; margin: 4px 0 0;">{{ $message }}</p> @enderror
                            </div>
                            <div style="width: 120px;">
                                <label for="postal_code" style="display: block; font-size: 0.85rem; margin-bottom: 4px; font-weight: 500;">Kode Pos *</label>
                                <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $user->postal_code ?? '') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid var(--subtle-border-color); border-radius: 6px; background: var(--body-bg); color: var(--text-color); font-family: inherit; font-size: 0.9rem; box-sizing: border-box;">
                                @error('postal_code') <p style="color: #e63946; font-size: 0.8rem; margin: 4px 0 0;">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div style="margin-bottom: 12px;">
                            <label for="courier_note" style="display: block; font-size: 0.85rem; margin-bottom: 4px; font-weight: 500;">Catatan untuk Kurir</label>
                            <textarea id="courier_note" name="courier_note" rows="2" style="width: 100%; padding: 10px 12px; border: 1px solid var(--subtle-border-color); border-radius: 6px; background: var(--body-bg); color: var(--text-color); font-family: inherit; font-size: 0.9rem; resize: vertical; box-sizing: border-box;">{{ old('courier_note') }}</textarea>
                        </div>

                        <h2 style="font-family: var(--font-heading); font-size: 0.95rem; color: var(--heading-color); margin: 20px 0 15px 0; border-bottom: 1px solid var(--subtle-border-color); padding-bottom: 10px;">Metode Pembayaran</h2>

                        <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px;">
                            <label style="display: flex; align-items: center; gap: 10px; padding: 10px 12px; border: 1px solid var(--subtle-border-color); border-radius: 6px; cursor: pointer; transition: border-color 0.2s;">
                                <input type="radio" name="payment_method" value="bca_va" {{ old('payment_method', 'bca_va') === 'bca_va' ? 'checked' : '' }} required>
                                <span style="font-size: 0.9rem;">BCA Virtual Account</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 10px; padding: 10px 12px; border: 1px solid var(--subtle-border-color); border-radius: 6px; cursor: pointer; transition: border-color 0.2s;">
                                <input type="radio" name="payment_method" value="mandiri_va" {{ old('payment_method') === 'mandiri_va' ? 'checked' : '' }}>
                                <span style="font-size: 0.9rem;">Mandiri Virtual Account</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 10px; padding: 10px 12px; border: 1px solid var(--subtle-border-color); border-radius: 6px; cursor: pointer; transition: border-color 0.2s;">
                                <input type="radio" name="payment_method" value="gopay" {{ old('payment_method') === 'gopay' ? 'checked' : '' }}>
                                <span style="font-size: 0.9rem;">GoPay</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 10px; padding: 10px 12px; border: 1px solid var(--subtle-border-color); border-radius: 6px; cursor: pointer; transition: border-color 0.2s;">
                                <input type="radio" name="payment_method" value="cod" {{ old('payment_method') === 'cod' ? 'checked' : '' }}>
                                <span style="font-size: 0.9rem;">Cash on Delivery (COD)</span>
                            </label>
                            @error('payment_method') <p style="color: #e63946; font-size: 0.8rem; margin: 4px 0 0;">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" class="cta-button" style="width: 100%; font-size: 1rem;">
                            Selesaikan Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
@endsection
