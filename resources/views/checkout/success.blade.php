@extends('layouts.app')

@section('title', 'Pesanan Berhasil')

@section('content')
<main>
    <div class="container" style="max-width: 700px; margin: 2rem auto; padding-bottom: 3rem;">
        {{-- Success Header --}}
        <div style="text-align: center; padding: 40px 20px; background-color: var(--card-bg); border: 1px solid var(--subtle-border-color); border-radius: 12px; margin-bottom: 24px;">
            <div style="font-size: 3rem; margin-bottom: 12px;">✅</div>
            <h1 style="font-family: var(--font-heading); font-size: 1.1rem; color: var(--heading-color); margin: 0 0 8px 0;">Transaksi Berhasil!</h1>
            <p style="font-size: 0.9rem; opacity: 0.7; margin: 0;">Terima kasih atas pesanan Anda. Berikut ringkasan transaksi.</p>
        </div>

        {{-- Order Details --}}
        <div style="background-color: var(--card-bg); border: 1px solid var(--subtle-border-color); border-radius: 8px; padding: 20px; margin-bottom: 20px;">
            <h2 style="font-family: var(--font-heading); font-size: 0.95rem; color: var(--heading-color); margin: 0 0 15px 0; border-bottom: 1px solid var(--subtle-border-color); padding-bottom: 10px;">Detail Pesanan</h2>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; font-size: 0.9rem; margin-bottom: 15px;">
                <div>
                    <span style="opacity: 0.6;">Nomor Pesanan</span>
                    <p style="font-weight: 600; color: var(--accent-color); margin: 2px 0 0;">{{ $order->order_number }}</p>
                </div>
                <div>
                    <span style="opacity: 0.6;">Status</span>
                    <p style="margin: 2px 0 0;"><span style="background: #2a9d8f; color: white; padding: 2px 10px; border-radius: 12px; font-size: 0.8rem; text-transform: capitalize;">{{ $order->status }}</span></p>
                </div>
                <div>
                    <span style="opacity: 0.6;">Metode Pembayaran</span>
                    <p style="font-weight: 500; margin: 2px 0 0; text-transform: uppercase;">{{ str_replace('_', ' ', $order->payment_method) }}</p>
                </div>
                <div>
                    <span style="opacity: 0.6;">Status Pembayaran</span>
                    <p style="margin: 2px 0 0;"><span style="background: #2a9d8f; color: white; padding: 2px 10px; border-radius: 12px; font-size: 0.8rem; text-transform: capitalize;">{{ $order->payment_status }}</span></p>
                </div>
            </div>
        </div>

        {{-- Recipient Info --}}
        <div style="background-color: var(--card-bg); border: 1px solid var(--subtle-border-color); border-radius: 8px; padding: 20px; margin-bottom: 20px;">
            <h2 style="font-family: var(--font-heading); font-size: 0.95rem; color: var(--heading-color); margin: 0 0 15px 0; border-bottom: 1px solid var(--subtle-border-color); padding-bottom: 10px;">Data Penerima</h2>

            <div style="font-size: 0.9rem; line-height: 1.6;">
                <p style="margin: 0;"><strong>{{ $order->fullname }}</strong></p>
                <p style="margin: 0; opacity: 0.8;">{{ $order->phone }}</p>
                <p style="margin: 0; opacity: 0.8;">{{ $order->address }}</p>
                <p style="margin: 0; opacity: 0.8;">{{ $order->city }}, {{ $order->postal_code }}</p>
                @if ($order->courier_note)
                    <p style="margin: 8px 0 0; font-style: italic; opacity: 0.6;">Catatan: {{ $order->courier_note }}</p>
                @endif
            </div>
        </div>

        {{-- Order Items --}}
        <div style="background-color: var(--card-bg); border: 1px solid var(--subtle-border-color); border-radius: 8px; padding: 20px; margin-bottom: 20px;">
            <h2 style="font-family: var(--font-heading); font-size: 0.95rem; color: var(--heading-color); margin: 0 0 15px 0; border-bottom: 1px solid var(--subtle-border-color); padding-bottom: 10px;">Daftar Item</h2>

            @foreach ($order->items as $item)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid var(--subtle-border-color);">
                    <div>
                        <p style="margin: 0 0 4px 0; font-weight: 500; font-size: 0.9rem;">{{ $item->product_name }}</p>
                        <p style="margin: 0; font-size: 0.8rem; opacity: 0.6;">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                    <span style="font-weight: 500; color: var(--accent-color); white-space: nowrap;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
            @endforeach

            <div style="padding-top: 15px; font-size: 0.95rem;">
                <p style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </p>
                <p style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                    <span>Ongkos Kirim</span>
                    <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </p>
                <p style="display: flex; justify-content: space-between; font-weight: bold; font-size: 1.1rem; border-top: 2px solid var(--subtle-border-color); padding-top: 10px; margin-top: 10px; color: var(--heading-color);">
                    <span>Total</span>
                    <span style="color: var(--accent-color);">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </p>
            </div>
        </div>

        {{-- Back to Home --}}
        <div style="text-align: center;">
            <a href="{{ route('home') }}" class="cta-button" style="text-decoration: none; display: inline-block; padding: 12px 30px;">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</main>
@endsection
