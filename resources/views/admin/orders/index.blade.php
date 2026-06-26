@extends('admin.layout')

@section('header_title', 'Kelola Pesanan')

@section('content')
<div class="content-card">
    <div class="card-header">
        <h3>Daftar Pesanan</h3>
    </div>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Total Pembayaran</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td style="font-weight: 600;">#ORD-{{ $order->id }}</td>
                <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                <td>
                    <div style="font-weight: 600;">{{ $order->user->name ?? 'Guest' }}</div>
                    <div style="font-size: 11px; color: #777;">{{ $order->user->email ?? '-' }}</div>
                </td>
                <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                <td>
                    <form action="/admin/orders/{{ $order->id }}/status" method="POST">
                        @csrf
                        <select name="status" onchange="this.form.submit()" class="form-control" style="padding: 4px 8px; font-size: 12px; width: auto; border-radius: 20px;">
                            <option value="PENDING" {{ $order->status == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                            <option value="PAID" {{ $order->status == 'PAID' ? 'selected' : '' }}>PAID</option>
                            <option value="SHIPPED" {{ $order->status == 'SHIPPED' ? 'selected' : '' }}>SHIPPED</option>
                            <option value="COMPLETED" {{ $order->status == 'COMPLETED' ? 'selected' : '' }}>COMPLETED</option>
                            <option value="CANCELLED" {{ $order->status == 'CANCELLED' ? 'selected' : '' }}>CANCELLED</option>
                        </select>
                    </form>
                </td>
                <td>
                    <div style="display: flex; gap: 8px;">
                        <a href="/admin/orders/{{ $order->id }}" class="btn btn-sm btn-outline"><i class="fas fa-search"></i> Detail</a>
                        <form action="/admin/orders/{{ $order->id }}" method="POST" onsubmit="return confirm('Hapus pesanan ini secara permanen?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline" style="color: #ff4d4f; border-color: #ff4d4f;"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="padding: 20px;">
        {{ $orders->links() }}
    </div>
</div>
@endsection
