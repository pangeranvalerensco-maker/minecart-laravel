@extends('layouts.app')

@section('content')
<main class="main-content" style="background-color: var(--body-bg); padding: 60px 0; min-height: calc(100vh - 80px);">
    <div class="container" style="max-width: 600px;">
        <div style="background: var(--card-bg); padding: 40px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); text-align: center;">
            <div style="width: 80px; height: 80px; background-color: #d1fae5; color: #10b981; font-size: 3rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                ✓
            </div>
            <h1 style="font-size: 1.8rem; margin-bottom: 10px;" data-translate-key="success-order-created">Pesanan Dibuat!</h1>
            <p style="color: #64748b; font-size: 1rem; margin-bottom: 30px;">
                <span data-translate-key="success-thank-you">Terima kasih telah berbelanja di MineCart.</span><br>
                <span data-translate-key="success-order-number">Nomor Pesanan Anda:</span> <strong>{{ $order->order_number }}</strong>
            </p>

            <div style="text-align: left; background: #f8fafc; padding: 20px; border-radius: 12px; margin-bottom: 30px;">
                <h3 style="font-size: 1.1rem; margin-bottom: 15px; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px;" data-translate-key="summary-title">Ringkasan Pembayaran</h3>
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span style="color: #64748b;">Subtotal</span>
                    <span style="font-weight: 500;">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span style="color: #64748b;">Ongkos Kirim</span>
                    <span style="font-weight: 500;">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-top: 15px; padding-top: 15px; border-top: 1px dashed #cbd5e1; font-size: 1.2rem; font-weight: 700;">
                    <span data-translate-key="order-grand-total">Total Pembayaran</span>
                    <span style="color: var(--primary-color);">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>

            @if($order->payment_method === 'cod')
                <div style="background-color: #fef3c7; color: #b45309; padding: 15px; border-radius: 8px; margin-bottom: 30px; font-weight: 500;" data-translate-key="success-cod-msg">
                    Pembayaran akan dilakukan di tempat (COD) saat barang sampai.
                </div>
                <a href="{{ route('home') }}" class="btn primary-btn" style="padding: 14px 30px; font-weight: 600; width: 100%;" data-translate-key="success-back-home">Kembali Berbelanja</a>
            @elseif($order->payment_method === 'xendit')
                @if($order->payment_status === 'paid')
                    <div style="background-color: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; margin-bottom: 30px; font-weight: 500;" data-translate-key="success-paid">
                        Pembayaran telah berhasil diterima!
                    </div>
                @else
                    <div style="background-color: #e0f2fe; color: #0369a1; padding: 15px; border-radius: 8px; margin-bottom: 30px; font-weight: 500;">
                        <span data-translate-key="success-waiting">Menunggu konfirmasi pembayaran dari Xendit.</span> 
                        @if($order->xendit_invoice_url)
                            <br><a href="{{ $order->xendit_invoice_url }}" target="_blank" style="color: #0284c7; text-decoration: underline;" data-translate-key="success-click-pay">Klik di sini jika Anda belum menyelesaikan pembayaran.</a>
                        @endif
                    </div>
                @endif
                <a href="{{ route('home') }}" class="btn primary-btn" style="padding: 14px 30px; font-weight: 600; width: 100%;" data-translate-key="success-back-home">Kembali Berbelanja</a>
            @endif
        </div>
    </div>
</main>
@endsection
