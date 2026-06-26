@extends('admin.layout')

@section('header_title', 'Detail Pesanan')

@section('content')
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
    <div>
        <div class="content-card">
            <div class="card-header">
                <h3>Informasi Pesanan #ORD-{{ $order->id }}</h3>
                <span class="badge {{ $order->status == 'PAID' ? 'badge-success' : 'badge-warning' }}">{{ $order->status }}</span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @if($order->items)
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <img src="{{ $item['img'] ?? '/images/placeholder.jpg' }}" alt="" style="width: 48px; height: 48px; border-radius: 8px; object-fit: cover;">
                                    <div>
                                        <div style="font-weight: 600;">{{ $item['name'] ?? 'Produk' }}</div>
                                        <div style="font-size: 11px; color: #777;">ID: {{ $item['id'] ?? $item['product_id'] ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>Rp {{ number_format($item['price'] ?? 0, 0, ',', '.') }}</td>
                            <td>{{ $item['quantity'] ?? 1 }}</td>
                            <td style="font-weight: 600;">Rp {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div style="padding: 24px; display: flex; justify-content: flex-end; border-top: 1px solid var(--admin-border);">
                <div style="text-align: right;">
                    <div style="font-size: 14px; color: #777; margin-bottom: 8px;">Total Pembayaran</div>
                    <div style="font-size: 24px; font-weight: 700; color: var(--admin-gold);">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="content-card">
            <div class="card-header">
                <h3>Informasi Pelanggan</h3>
            </div>
            <div style="padding: 24px;">
                <div style="margin-bottom: 20px;">
                    <div style="font-size: 12px; color: #777; text-transform: uppercase; margin-bottom: 4px;">Nama</div>
                    <div style="font-weight: 600;">{{ $order->user->name ?? 'Guest' }}</div>
                </div>
                <div style="margin-bottom: 20px;">
                    <div style="font-size: 12px; color: #777; text-transform: uppercase; margin-bottom: 4px;">Email</div>
                    <div>{{ $order->user->email ?? '-' }}</div>
                </div>
                <div style="margin-bottom: 20px;">
                    <div style="font-size: 12px; color: #777; text-transform: uppercase; margin-bottom: 4px;">No. Telepon</div>
                    <div>{{ $order->user->phone ?? '-' }}</div>
                </div>
                <hr style="border: none; border-top: 1px solid var(--admin-border); margin: 20px 0;">
                <div style="margin-bottom: 20px;">
                    <div style="font-size: 12px; color: #777; text-transform: uppercase; margin-bottom: 4px;">Status Pesanan</div>
                    <form action="/admin/orders/{{ $order->id }}/status" method="POST">
                        @csrf
                        <select name="status" onchange="this.form.submit()" class="form-control">
                            <option value="PENDING" {{ $order->status == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                            <option value="PAID" {{ $order->status == 'PAID' ? 'selected' : '' }}>PAID</option>
                            <option value="SHIPPED" {{ $order->status == 'SHIPPED' ? 'selected' : '' }}>SHIPPED</option>
                            <option value="COMPLETED" {{ $order->status == 'COMPLETED' ? 'selected' : '' }}>COMPLETED</option>
                            <option value="CANCELLED" {{ $order->status == 'CANCELLED' ? 'selected' : '' }}>CANCELLED</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
