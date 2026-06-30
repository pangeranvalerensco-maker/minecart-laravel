@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<main>
    <div class="container page-title" style="margin-top: 2rem;">
        <h1>Checkout</h1>
    </div>

    <section class="cart-section" style="padding-bottom: 3rem;">
        <div class="container" style="display: flex; gap: 40px; flex-wrap: wrap; flex-direction: row-reverse;">
            
            {{-- Right Column: Order Summary (Now first in DOM for reverse flow, or visually right) --}}
            <div style="flex: 1; min-width: 350px; max-width: 450px;">
                <div style="background-color: var(--card-bg); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 25px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); position: sticky; top: 100px;">
                    <h2 style="font-family: var(--font-heading); font-size: 1.2rem; font-weight: 700; color: var(--heading-color); margin: 0 0 20px 0; border-bottom: 2px solid var(--subtle-border-color); padding-bottom: 15px;" data-translate-key="summary-title">Ringkasan Pesanan</h2>
                    
                    <div style="max-height: 400px; overflow-y: auto; padding-right: 10px; margin-bottom: 20px;">
                        @foreach ($cartItems as $item)
                            <div style="display: flex; gap: 15px; align-items: center; padding: 12px 0; border-bottom: 1px solid var(--subtle-border-color);">
                                <div style="position: relative;">
                                    <img src="{{ asset($item['product']->images[0] ?? 'assets/logo-minecart.png') }}" alt="{{ $item['product']->title_id }}" style="width: 65px; height: 65px; object-fit: cover; border-radius: 8px; border: 1px solid var(--subtle-border-color);">
                                    <span style="position: absolute; top: -8px; right: -8px; background: var(--subtle-border-color); color: var(--text-color); font-size: 0.75rem; font-weight: bold; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">{{ $item['quantity'] }}</span>
                                </div>
                                <div style="flex-grow: 1;">
                                    <p class="product-title" style="margin: 0 0 5px 0; font-weight: 600; color: var(--heading-color); font-size: 0.9rem; line-height: 1.3;" data-title-id="{{ $item['product']->title_id }}" data-title-en="{{ $item['product']->title_en }}">{{ $item['product']->title_id }}</p>
                                </div>
                                <span style="font-weight: 600; color: var(--heading-color); font-size: 0.95rem; white-space: nowrap;">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div style="padding-top: 10px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.95rem; color: var(--text-color);">
                            <span data-translate-key="order-subtotal">Subtotal</span>
                            <span style="font-weight: 600; color: var(--heading-color);">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 0.95rem; color: var(--text-color);">
                            <span data-translate-key="order-shipping">Ongkos Kirim</span>
                            <span id="shipping-cost-display" style="font-weight: 600; color: var(--heading-color);">Menunggu tujuan</span>
                        </div>
                        <div id="discount-row" style="display: none; justify-content: space-between; margin-bottom: 15px; font-size: 0.95rem; color: #10b981;">
                            <span>Diskon Kupon</span>
                            <span id="discount-display" style="font-weight: 600;">-Rp 0</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-top: 15px; font-size: 1.25rem; font-weight: bold; border-top: 2px dashed var(--subtle-border-color); padding-top: 20px; color: var(--heading-color);">
                            <span data-translate-key="order-grand-total">Total Keseluruhan</span>
                            <span id="total-display" style="color: var(--accent-color);">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Left Column: Checkout Form (Data, Shipping, Payment) --}}
            <div style="flex: 1.5; min-width: 300px;">
                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                    
                    <!-- Data Penerima -->
                    <div style="background-color: var(--card-bg); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 30px; margin-bottom: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                        <h2 style="font-family: var(--font-heading); font-size: 1.1rem; font-weight: 700; color: var(--heading-color); margin: 0 0 20px 0; border-bottom: 1px solid var(--subtle-border-color); padding-bottom: 10px;">Data Penerima</h2>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
                            <div>
                                <label for="fullname" style="display: block; font-size: 0.85rem; margin-bottom: 6px; font-weight: 600; color: var(--text-color);">Nama Lengkap *</label>
                                <input type="text" id="fullname" name="fullname" value="{{ old('fullname', $user->name ?? '') }}" required style="width: 100%; padding: 12px 15px; border: 1px solid var(--subtle-border-color); border-radius: 8px; background: var(--body-bg); color: var(--heading-color); font-family: inherit; font-size: 0.95rem; box-sizing: border-box; transition: all 0.2s;" onfocus="this.style.borderColor='var(--accent-color)';">
                                @error('fullname') <p style="color: #ef4444; font-size: 0.8rem; margin: 4px 0 0;">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="phone" style="display: block; font-size: 0.85rem; margin-bottom: 6px; font-weight: 600; color: var(--text-color);">Nomor Telepon *</label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone ?? '') }}" required style="width: 100%; padding: 12px 15px; border: 1px solid var(--subtle-border-color); border-radius: 8px; background: var(--body-bg); color: var(--heading-color); font-family: inherit; font-size: 0.95rem; box-sizing: border-box; transition: all 0.2s;" onfocus="this.style.borderColor='var(--accent-color)';">
                                @error('phone') <p style="color: #ef4444; font-size: 0.8rem; margin: 4px 0 0;">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div style="margin-bottom: 15px;">
                            <label for="address" style="display: block; font-size: 0.85rem; margin-bottom: 6px; font-weight: 600; color: var(--text-color);">Alamat Lengkap *</label>
                            <textarea id="address" name="address" rows="3" required style="width: 100%; padding: 12px 15px; border: 1px solid var(--subtle-border-color); border-radius: 8px; background: var(--body-bg); color: var(--heading-color); font-family: inherit; font-size: 0.95rem; resize: vertical; box-sizing: border-box; transition: all 0.2s;" onfocus="this.style.borderColor='var(--accent-color)';">{{ old('address', $user->address ?? '') }}</textarea>
                            @error('address') <p style="color: #ef4444; font-size: 0.8rem; margin: 4px 0 0;">{{ $message }}</p> @enderror
                        </div>

                        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 15px;">
                            <div>
                                <label for="city" style="display: block; font-size: 0.85rem; margin-bottom: 6px; font-weight: 600; color: var(--text-color);">Kota *</label>
                                <input type="text" id="city" name="city" value="{{ old('city', $user->city ?? '') }}" required style="width: 100%; padding: 12px 15px; border: 1px solid var(--subtle-border-color); border-radius: 8px; background: var(--body-bg); color: var(--heading-color); font-family: inherit; font-size: 0.95rem; box-sizing: border-box; transition: all 0.2s;" onfocus="this.style.borderColor='var(--accent-color)';">
                                @error('city') <p style="color: #ef4444; font-size: 0.8rem; margin: 4px 0 0;">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="postal_code" style="display: block; font-size: 0.85rem; margin-bottom: 6px; font-weight: 600; color: var(--text-color);">Kode Pos *</label>
                                <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $user->postal_code ?? '') }}" required style="width: 100%; padding: 12px 15px; border: 1px solid var(--subtle-border-color); border-radius: 8px; background: var(--body-bg); color: var(--heading-color); font-family: inherit; font-size: 0.95rem; box-sizing: border-box; transition: all 0.2s;" onfocus="this.style.borderColor='var(--accent-color)';">
                                @error('postal_code') <p style="color: #ef4444; font-size: 0.8rem; margin: 4px 0 0;">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="courier_note" style="display: block; font-size: 0.85rem; margin-bottom: 6px; font-weight: 600; color: var(--text-color);">Catatan untuk Kurir (Opsional)</label>
                            <input type="text" id="courier_note" name="courier_note" value="{{ old('courier_note') }}" placeholder="Contoh: Titip di pos satpam" style="width: 100%; padding: 12px 15px; border: 1px solid var(--subtle-border-color); border-radius: 8px; background: var(--body-bg); color: var(--heading-color); font-family: inherit; font-size: 0.95rem; box-sizing: border-box; transition: all 0.2s;" onfocus="this.style.borderColor='var(--accent-color)';">
                        </div>
                    </div>

                    <!-- Pengiriman -->
                    <div style="background-color: var(--card-bg); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 30px; margin-bottom: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                        <h2 style="font-family: var(--font-heading); font-size: 1.1rem; font-weight: 700; color: var(--heading-color); margin: 0 0 20px 0; border-bottom: 1px solid var(--subtle-border-color); padding-bottom: 10px;" data-translate-key="checkout-shipping">Pengiriman</h2>
                        
                        <div>
                            <label for="courier" style="display: block; font-size: 0.85rem; margin-bottom: 8px; font-weight: 600; color: var(--text-color);">Pilih Kurir *</label>
                            <div style="position: relative;">
                                <select id="courier" name="courier" required style="appearance: none; width: 100%; padding: 15px; border: 1px solid var(--subtle-border-color); border-radius: 8px; background: var(--body-bg); color: var(--heading-color); font-family: inherit; font-size: 0.95rem; font-weight: 500; box-sizing: border-box; cursor: pointer; transition: all 0.2s;" onfocus="this.style.borderColor='var(--accent-color)';">
                                    <option value="jne" {{ old('courier') === 'jne' ? 'selected' : '' }}>JNE Express</option>
                                    <option value="jnt" {{ old('courier') === 'jnt' ? 'selected' : '' }}>J&T Express</option>
                                    <option value="pos" {{ old('courier') === 'pos' ? 'selected' : '' }}>POS Indonesia</option>
                                    <option value="tiki" {{ old('courier') === 'tiki' ? 'selected' : '' }}>TIKI</option>
                                </select>
                                <div style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; color: var(--text-color);">▼</div>
                            </div>
                            @error('courier') <p style="color: #ef4444; font-size: 0.8rem; margin: 4px 0 0;">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Kupon / Voucher -->
                    <div style="background-color: var(--card-bg); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 30px; margin-bottom: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                        <h2 style="font-family: var(--font-heading); font-size: 1.1rem; font-weight: 700; color: var(--heading-color); margin: 0 0 20px 0; border-bottom: 1px solid var(--subtle-border-color); padding-bottom: 10px;">Kode Kupon (Opsional)</h2>
                        
                        <div style="display: flex; gap: 10px;">
                            <input type="text" id="coupon_code_input" placeholder="Masukkan kode kupon" style="flex-grow: 1; padding: 12px 15px; border: 1px solid var(--subtle-border-color); border-radius: 8px; background: var(--body-bg); color: var(--heading-color); font-family: inherit; font-size: 0.95rem; text-transform: uppercase;">
                            <button type="button" id="apply-coupon-btn" class="btn btn-secondary" style="padding: 12px 20px; border-radius: 8px; font-weight: 600;">Terapkan</button>
                        </div>
                        <p id="coupon-message" style="margin-top: 10px; font-size: 0.85rem;"></p>
                        
                        <input type="hidden" name="coupon_code" id="hidden_coupon_code" value="">
                    </div>

                    <!-- Pembayaran -->
                    <div style="background-color: var(--card-bg); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 30px; margin-bottom: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                        <h2 style="font-family: var(--font-heading); font-size: 1.1rem; font-weight: 700; color: var(--heading-color); margin: 0 0 20px 0; border-bottom: 1px solid var(--subtle-border-color); padding-bottom: 10px;" data-translate-key="checkout-payment">Metode Pembayaran</h2>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 10px;">
                            <label style="display: flex; align-items: center; gap: 12px; padding: 15px; border: 1px solid var(--subtle-border-color); border-radius: 8px; background: var(--body-bg); cursor: pointer; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--accent-color)'" onmouseout="this.style.borderColor='var(--subtle-border-color)'">
                                <input type="radio" name="payment_method" value="xendit" {{ old('payment_method', 'xendit') === 'xendit' ? 'checked' : '' }} required style="accent-color: var(--accent-color); width: 18px; height: 18px;">
                                <span style="font-weight: 500; color: var(--heading-color);">Bayar Otomatis (Xendit VA / e-Wallet)</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 12px; padding: 15px; border: 1px solid var(--subtle-border-color); border-radius: 8px; background: var(--body-bg); cursor: pointer; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--accent-color)'" onmouseout="this.style.borderColor='var(--subtle-border-color)'">
                                <input type="radio" name="payment_method" value="cod" {{ old('payment_method') === 'cod' ? 'checked' : '' }} style="accent-color: var(--accent-color); width: 18px; height: 18px;">
                                <span style="font-weight: 500; color: var(--heading-color);">Bayar di Tempat (COD)</span>
                            </label>
                        </div>
                        <div style="display: flex; justify-content: flex-end; align-items: center; gap: 8px; margin-bottom: 25px;">
                            <span style="font-size: 0.75rem; color: var(--text-color); opacity: 0.8;">Transaksi diverifikasi secara otomatis</span>
                        </div>
                        @error('payment_method') <p style="color: #ef4444; font-size: 0.8rem; margin-top: -15px; margin-bottom: 20px;">{{ $message }}</p> @enderror

                        <button type="submit" class="cta-button" style="width: 100%; font-size: 1.1rem; padding: 15px; border-radius: 8px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 10px; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(230,57,70,0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                            <span data-translate-key="checkout-pay">Selesaikan Pembayaran</span> <span style="font-size: 1.2rem;">🔒</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cityInput = document.getElementById('city');
    const courierSelect = document.getElementById('courier');
    const shippingCostDisplay = document.getElementById('shipping-cost-display');
    const totalDisplay = document.getElementById('total-display');
    const subtotal = {{ $subtotal }};
    const csrfToken = document.querySelector('input[name="_token"]').value;

    const couponInput = document.getElementById('coupon_code_input');
    const hiddenCouponInput = document.getElementById('hidden_coupon_code');
    const applyCouponBtn = document.getElementById('apply-coupon-btn');
    const couponMessage = document.getElementById('coupon-message');
    const discountRow = document.getElementById('discount-row');
    const discountDisplay = document.getElementById('discount-display');

    let currentShippingCost = 0;
    let currentDiscount = 0;

    function updateTotal() {
        let finalTotal = subtotal + currentShippingCost - currentDiscount;
        if (finalTotal < 0) finalTotal = 0;
        totalDisplay.textContent = 'Rp ' + finalTotal.toLocaleString('id-ID');
    }

    function calculateShipping() {
        const city = cityInput.value.trim();
        const courier = courierSelect.value;
        
        if (!city) {
            shippingCostDisplay.textContent = 'Menunggu tujuan...';
            currentShippingCost = 0;
            updateTotal();
            return;
        }

        shippingCostDisplay.textContent = 'Menghitung...';

        fetch('{{ route("checkout.calculate_shipping") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ city: city, courier: courier })
        })
        .then(response => response.json())
        .then(data => {
            currentShippingCost = data.shipping_cost;
            shippingCostDisplay.textContent = 'Rp ' + currentShippingCost.toLocaleString('id-ID');
            updateTotal();
        })
        .catch(err => {
            console.error('Shipping calculation error:', err);
            shippingCostDisplay.textContent = 'Gagal menghitung';
            currentShippingCost = 0;
            updateTotal();
        });
    }

    applyCouponBtn.addEventListener('click', function() {
        const code = couponInput.value.trim();
        if (!code) return;

        couponMessage.style.color = 'var(--text-color)';
        couponMessage.textContent = 'Mengecek kupon...';

        fetch('{{ route("checkout.check_coupon") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ code: code })
        })
        .then(res => res.json())
        .then(data => {
            if (data.valid) {
                couponMessage.style.color = '#10b981';
                couponMessage.textContent = data.message;
                hiddenCouponInput.value = code;
                
                const coupon = data.coupon;
                if (coupon.type === 'fixed') {
                    currentDiscount = Math.min(coupon.value, subtotal);
                } else {
                    let d = subtotal * (coupon.value / 100);
                    if (coupon.max_discount) {
                        d = Math.min(d, coupon.max_discount);
                    }
                    currentDiscount = Math.min(d, subtotal);
                }
                
                discountRow.style.display = 'flex';
                discountDisplay.textContent = '-Rp ' + currentDiscount.toLocaleString('id-ID');
                updateTotal();
            } else {
                couponMessage.style.color = '#ef4444';
                couponMessage.textContent = data.message;
                hiddenCouponInput.value = '';
                currentDiscount = 0;
                discountRow.style.display = 'none';
                updateTotal();
            }
        })
        .catch(err => {
            console.error(err);
            couponMessage.style.color = '#ef4444';
            couponMessage.textContent = 'Gagal memverifikasi kupon.';
        });
    });

    cityInput.addEventListener('blur', calculateShipping);
    courierSelect.addEventListener('change', calculateShipping);
    
    if (cityInput.value) {
        calculateShipping();
    }
});
</script>
@endsection
