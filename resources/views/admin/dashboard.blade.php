@extends('admin.layout')

@section('header_title', 'Dashboard Overview')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0 d-flex align-items-center justify-content-center rounded" style="width: 48px; height: 48px; background-color: rgba(198, 161, 91, 0.1); color: #C6A15B; font-size: 24px;">
                        <i class="fas fa-wallet"></i>
                    </div>
                </div>
                <div class="text-muted small text-uppercase fw-semibold mb-1">Total Penjualan</div>
                <h3 class="fw-bold mb-0 text-dark">Rp {{ number_format($totalSales, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0 d-flex align-items-center justify-content-center rounded" style="width: 48px; height: 48px; background-color: rgba(24, 144, 255, 0.1); color: #1890ff; font-size: 24px;">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                </div>
                <div class="text-muted small text-uppercase fw-semibold mb-1">Total Pesanan</div>
                <h3 class="fw-bold mb-0 text-dark">{{ $totalOrders }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0 d-flex align-items-center justify-content-center rounded" style="width: 48px; height: 48px; background-color: rgba(0, 168, 84, 0.1); color: #00a854; font-size: 24px;">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
                <div class="text-muted small text-uppercase fw-semibold mb-1">Total Produk</div>
                <h3 class="fw-bold mb-0 text-dark">{{ $totalProducts }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0 d-flex align-items-center justify-content-center rounded" style="width: 48px; height: 48px; background-color: rgba(255, 77, 79, 0.1); color: #ff4d4f; font-size: 24px;">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="text-muted small text-uppercase fw-semibold mb-1">Total Pelanggan</div>
                <h3 class="fw-bold mb-0 text-dark">{{ $totalUsers }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Pesanan Terbaru</h5>
                <a href="/admin/orders" class="btn btn-outline-gold btn-sm">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
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
                                <td class="fw-semibold">#ORD-{{ $order->id }}</td>
                                <td>{{ $order->user->name ?? 'Guest' }}</td>
                                <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td>
                                    @php
                                        $badgeClass = 'bg-info text-dark';
                                        $status = strtoupper($order->status);
                                        if(in_array($status, ['PAID', 'SUCCESS', 'SEDANG DIKEMAS', 'SELESAI'])) $badgeClass = 'bg-success';
                                        if(in_array($status, ['CANCELLED', 'BATAL', 'FAILED'])) $badgeClass = 'bg-danger';
                                        if(in_array($status, ['SHIPPED', 'DIKIRIM'])) $badgeClass = 'bg-warning text-dark';
                                        if(strpos($status, 'MENUNGGU') !== false) $badgeClass = 'bg-info text-dark';
                                    @endphp
                                    <span class="badge rounded-pill {{ $badgeClass }} px-3 py-2">{{ $order->status }}</span>
                                </td>
                                <td>
                                    <a href="/admin/orders/{{ $order->id }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="fw-bold mb-0">Stok Menipis</h5>
            </div>
            <div class="card-body">
                @foreach($lowStockProducts as $product)
                <div class="d-flex align-items-center gap-3 py-3 border-bottom">
                    <img src="{{ $product->img }}" alt="" class="rounded object-fit-cover" style="width: 48px; height: 48px;">
                    <div class="flex-grow-1">
                        <div class="fw-semibold" style="font-size: 14px;">{{ $product->name }}</div>
                        <div class="small text-danger">Tersisa: {{ $product->stock }} unit</div>
                    </div>
                    <a href="/admin/products/edit/{{ $product->id }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-edit"></i></a>
                </div>
                @endforeach
                @if($lowStockProducts->isEmpty())
                    <p class="text-center text-muted py-4 mb-0">Semua stok aman.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
