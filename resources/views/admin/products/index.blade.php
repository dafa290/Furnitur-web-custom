@extends('admin.layout')

@section('header_title', 'Kelola Produk')

@section('content')
<div class="content-card">
    <div class="card-header">
        <h3>Semua Produk</h3>
        <a href="/admin/products/create" class="btn btn-gold"><i class="fas fa-plus"></i> Tambah Produk</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Gambar</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>
                    <img src="{{ $product->img }}" alt="" style="width: 60px; height: 60px; border-radius: 12px; object-fit: cover; border: 1px solid #eee;">
                </td>
                <td>
                    <div style="font-weight: 600;">{{ $product->name }}</div>
                    <div style="font-size: 11px; color: #777;">ID: #PRD-{{ $product->id }}</div>
                </td>
                <td><span class="badge badge-info">{{ $product->category }}</span></td>
                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td>
                    <span style="font-weight: 600; color: {{ $product->stock < 10 ? '#ff4d4f' : 'inherit' }}">
                        {{ $product->stock }}
                    </span>
                </td>
                <td>
                    <div style="display: flex; gap: 8px;">
                        <a href="/admin/products/edit/{{ $product->id }}" class="btn btn-sm btn-outline"><i class="fas fa-edit"></i> Edit</a>
                        <form action="/admin/products/{{ $product->id }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline" style="color: #ff4d4f; border-color: #ff4d4f;"><i class="fas fa-trash"></i> Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="padding: 20px;">
        {{ $products->links() }}
    </div>
</div>
@endsection
