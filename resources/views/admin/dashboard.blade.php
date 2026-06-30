@extends('admin.layout')

@section('content')
<h2>Superadmin Dashboard</h2>
<div class="grid">
    <div class="stat-card">
        <h3>Total Users</h3>
        <div class="value">{{ number_format($totalUsers) }}</div>
    </div>
    <div class="stat-card">
        <h3>Total Orders</h3>
        <div class="value">{{ number_format($totalOrders) }}</div>
    </div>
    <div class="stat-card">
        <h3>Total GTV</h3>
        <div class="value">Rp {{ number_format($totalGTV, 0, ',', '.') }}</div>
    </div>
</div>
@endsection
