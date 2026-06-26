@extends('admin.layout')

@section('header_title', 'Dashboard Overview')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(198, 161, 91, 0.1); color: var(--admin-gold);">
            <i class="fas fa-wallet"></i>
        </div>
        <div class="stat-label">Total Penjualan</div>
        <div class="stat-value">Rp {{ number_format($totalSales, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(24, 144, 255, 0.1); color: #1890ff;">
            <i class="fas fa-shopping-bag"></i>
        </div>
        <div class="stat-label">Total Pesanan</div>
        <div class="stat-value">{{ $totalOrders }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(0, 168, 84, 0.1); color: #00a854;">
            <i class="fas fa-box"></i>
        </div>
        <div class="stat-label">Total Produk</div>
        <div class="stat-value">{{ $totalProducts }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: rgba(255, 77, 79, 0.1); color: #ff4d4f;">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-label">Total Pelanggan</div>
        <div class="stat-value">{{ $totalUsers }}</div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
    <div class="content-card">
        <div class="card-header">
            <h3>Pesanan Terbaru</h3>
            <a href="/admin/orders" class="btn btn-outline btn-sm">Lihat Semua</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                <tr>
                    <td style="font-weight: 600;">#ORD-{{ $order->id }}</td>
                    <td>{{ $order->user->name ?? 'Guest' }}</td>
                    <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td>
                        @php
                            $badgeClass = 'badge-info';
                            $status = strtoupper($order->status);
                            if(in_array($status, ['PAID', 'SUCCESS', 'SEDANG DIKEMAS', 'SELESAI'])) $badgeClass = 'badge-success';
                            if(in_array($status, ['CANCELLED', 'BATAL', 'FAILED'])) $badgeClass = 'badge-danger';
                            if(in_array($status, ['SHIPPED', 'DIKIRIM'])) $badgeClass = 'badge-warning';
                            if(strpos($status, 'MENUNGGU') !== false) $badgeClass = 'badge-info';
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $order->status }}</span>
                    </td>
                    <td>
                        <a href="/admin/orders/{{ $order->id }}" class="btn btn-sm btn-outline"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="content-card">
        <div class="card-header">
            <h3>Stok Menipis</h3>
        </div>
        <div style="padding: 0 24px 20px;">
            @foreach($lowStockProducts as $product)
            <div style="display: flex; align-items: center; gap: 12px; padding: 16px 0; border-bottom: 1px solid var(--admin-border);">
                <img src="{{ $product->img }}" alt="" style="width: 48px; height: 48px; border-radius: 8px; object-fit: cover;">
                <div style="flex-grow: 1;">
                    <div style="font-size: 14px; font-weight: 600;">{{ $product->name }}</div>
                    <div style="font-size: 12px; color: #ff4d4f;">Tersisa: {{ $product->stock }} unit</div>
                </div>
                <a href="/admin/products/edit/{{ $product->id }}" class="btn btn-sm btn-outline"><i class="fas fa-edit"></i></a>
            </div>
            @endforeach
            @if($lowStockProducts->isEmpty())
                <p style="text-align: center; color: #777; padding: 20px;">Semua stok aman.</p>
            @endif
        </div>
    </div>
</div>
@endsection
