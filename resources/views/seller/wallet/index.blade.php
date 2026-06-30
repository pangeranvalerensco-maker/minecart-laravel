@extends('layouts.app')

@section('title', 'Dompet & Penarikan')

@section('content')
<main class="main-content">
    <div class="account-container">
        <!-- Sidebar Navigation -->
        <aside class="account-sidebar">
            <div class="user-info">
                <h3>Toko: {{ auth()->user()->store_name }}</h3>
                <p>{{ auth()->user()->email }}</p>
            </div>
            <nav class="account-nav">
                <a href="{{ route('account.index') }}" data-translate-key="my-profile">Profil Saya</a>
                <a href="{{ route('seller.products.index') }}" data-translate-key="seller-products">Produk Saya</a>
                <a href="{{ route('seller.orders.index') }}" data-translate-key="seller-orders">Pesanan Masuk</a>
                <a href="{{ route('seller.wallet.index') }}" class="active" data-translate-key="seller-wallet">Dompet & Penarikan</a>
                <a href="{{ route('seller.analytics.index') }}" data-translate-key="seller-analytics">Analitik Penjualan</a>
                <form action="{{ route('logout') }}" method="POST" style="margin-top: auto;">
                    @csrf
                    <button type="submit" class="logout-btn" data-translate-key="logout">Logout</button>
                </form>
            </nav>
        </aside>

        <section class="account-content">
            <h1 class="page-title">Dompet & Penarikan</h1>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="wallet-balance-card" style="background: var(--bg-surface); padding: 20px; border-radius: 8px; border: 1px solid var(--border-color); margin-bottom: 20px;">
                <h3>Saldo Tersedia</h3>
                <h2 style="color: var(--primary-color);">Rp {{ number_format($wallet->balance, 0, ',', '.') }}</h2>
            </div>

            <div class="withdrawal-form-card" style="background: var(--bg-surface); padding: 20px; border-radius: 8px; border: 1px solid var(--border-color); margin-bottom: 30px;">
                <h3>Ajukan Penarikan Dana</h3>
                <form action="{{ route('seller.wallet.withdraw') }}" method="POST" style="margin-top: 15px;">
                    @csrf
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label>Jumlah Penarikan (Rp)</label>
                        <input type="number" name="amount" min="10000" max="{{ $wallet->balance }}" class="form-input" style="width:100%; padding: 10px;" required>
                        <small>Min. penarikan Rp 10.000</small>
                    </div>
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label>Nama Bank</label>
                        <input type="text" name="bank_name" class="form-input" style="width:100%; padding: 10px;" required placeholder="Contoh: BCA / Mandiri">
                    </div>
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label>Nomor Rekening</label>
                        <input type="text" name="account_number" class="form-input" style="width:100%; padding: 10px;" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label>Nama Pemilik Rekening</label>
                        <input type="text" name="account_name" class="form-input" style="width:100%; padding: 10px;" required>
                    </div>
                    <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">Tarik Dana</button>
                </form>
            </div>

            <div class="history-section">
                <h3>Riwayat Penarikan</h3>
                <div class="table-responsive">
                    <table class="table" style="width: 100%; margin-bottom: 20px;">
                        <thead>
                            <tr style="text-align: left; border-bottom: 1px solid var(--border-color);">
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Bank</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($withdrawals as $wd)
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 10px 0;">{{ $wd->created_at->format('d M Y H:i') }}</td>
                                <td>Rp {{ number_format($wd->amount, 0, ',', '.') }}</td>
                                <td>{{ $wd->bank_name }} - {{ $wd->account_number }}</td>
                                <td>{{ ucfirst($wd->status) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 20px;">Belum ada riwayat penarikan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $withdrawals->links() }}
                </div>
            </div>

            <div class="history-section" style="margin-top: 30px;">
                <h3>Riwayat Transaksi Dompet</h3>
                <div class="table-responsive">
                    <table class="table" style="width: 100%;">
                        <thead>
                            <tr style="text-align: left; border-bottom: 1px solid var(--border-color);">
                                <th>Tanggal</th>
                                <th>Tipe</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $tx)
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 10px 0;">{{ $tx->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    @if($tx->type === 'credit')
                                        <span style="color: #10b981;">Masuk</span>
                                    @else
                                        <span style="color: #ef4444;">Keluar</span>
                                    @endif
                                </td>
                                <td>Rp {{ number_format($tx->amount, 0, ',', '.') }}</td>
                                <td>{{ $tx->description }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 20px;">Belum ada transaksi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $transactions->links() }}
                </div>
            </div>

        </section>
    </div>
</main>
@endsection
