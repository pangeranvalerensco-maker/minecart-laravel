@extends('layouts.app')

@section('title', 'Analitik Penjualan')

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
                <a href="{{ route('seller.wallet.index') }}" data-translate-key="seller-wallet">Dompet & Penarikan</a>
                <a href="{{ route('seller.analytics.index') }}" class="active" data-translate-key="seller-analytics">Analitik Penjualan</a>
                <form action="{{ route('logout') }}" method="POST" style="margin-top: auto;">
                    @csrf
                    <button type="submit" class="logout-btn" data-translate-key="logout">Logout</button>
                </form>
            </nav>
        </aside>

        <section class="account-content">
            <h1 class="page-title">Statistik Penjualan</h1>

            <div class="chart-container" style="background: var(--bg-surface); padding: 20px; border-radius: 8px; border: 1px solid var(--border-color); margin-bottom: 20px;">
                <h3>Pendapatan Harian (30 Hari Terakhir)</h3>
                <canvas id="revenueChart" width="400" height="150"></canvas>
            </div>

            <div class="chart-container" style="background: var(--bg-surface); padding: 20px; border-radius: 8px; border: 1px solid var(--border-color);">
                <h3>Top 5 Produk Paling Laris</h3>
                <canvas id="productsChart" width="400" height="150"></canvas>
            </div>
        </section>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data from server
    const dates = @json($chartDates);
    const totals = @json($chartTotals);
    const productNames = @json($topProductNames);
    const productQuantities = @json($topProductQuantities);

    // Common styling colors matching premium dark mode
    const gridColor = '#334155';
    const textColor = '#94a3b8';
    
    Chart.defaults.color = textColor;
    Chart.defaults.borderColor = gridColor;

    // Line Chart: Revenue
    const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctxRevenue, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: totals,
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Bar Chart: Top Products
    const ctxProducts = document.getElementById('productsChart').getContext('2d');
    new Chart(ctxProducts, {
        type: 'bar',
        data: {
            labels: productNames,
            datasets: [{
                label: 'Terjual (pcs)',
                data: productQuantities,
                backgroundColor: '#10b981',
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endsection
