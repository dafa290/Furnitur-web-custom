@extends('admin.layout')

@section('header_title', 'Edit Produk')

@section('content')
<div class="content-card" style="max-width: 800px;">
    <div class="card-header">
        <h3>Detail Produk: {{ $product->name }}</h3>
    </div>
    <div style="padding: 30px;">
        <form action="/admin/products/update/{{ $product->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <div class="form-group">
                    <label>Nama Produk</label>
                    <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="category" class="form-control" required>
                        <option value="Kursi" {{ $product->category == 'Kursi' ? 'selected' : '' }}>Kursi</option>
                        <option value="Meja" {{ $product->category == 'Meja' ? 'selected' : '' }}>Meja</option>
                        <option value="Sofa" {{ $product->category == 'Sofa' ? 'selected' : '' }}>Sofa</option>
                        <option value="Lemari" {{ $product->category == 'Lemari' ? 'selected' : '' }}>Lemari</option>
                        <option value="Tempat Tidur" {{ $product->category == 'Tempat Tidur' ? 'selected' : '' }}>Tempat Tidur</option>
                        <option value="Dekorasi" {{ $product->category == 'Dekorasi' ? 'selected' : '' }}>Dekorasi</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Harga (Rp)</label>
                    <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
                </div>
                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <label>Gambar Produk</label>
                    @if($product->img)
                        <div style="margin-bottom: 10px;">
                            <img src="{{ $product->img }}" alt="" style="width: 100px; height: 100px; border-radius: 8px; object-fit: cover;">
                        </div>
                    @endif
                    <input type="file" name="image" class="form-control">
                    <small style="color: #777;">Kosongkan jika tidak ingin mengubah gambar.</small>
                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control" rows="4">{{ $product->description }}</textarea>
                </div>
                <div class="form-group">
                    <label>Material</label>
                    <input type="text" name="material" class="form-control" value="{{ $product->material }}">
                </div>
                <div class="form-group">
                    <label>Warna Dasar</label>
                    <select name="color" class="form-control">
                        <option value="">-- Pilih Warna Dasar --</option>
                        <option value="Natural" {{ $product->color == 'Natural' ? 'selected' : '' }}>Natural</option>
                        <option value="Walnut" {{ $product->color == 'Walnut' ? 'selected' : '' }}>Walnut</option>
                        <option value="Olive" {{ $product->color == 'Olive' ? 'selected' : '' }}>Olive</option>
                        <option value="Beige" {{ $product->color == 'Beige' ? 'selected' : '' }}>Beige</option>
                        <option value="Charcoal" {{ $product->color == 'Charcoal' ? 'selected' : '' }}>Charcoal</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Dimensi</label>
                    <input type="text" name="dimensions" class="form-control" value="{{ $product->dimensions }}">
                </div>
            </div>
            
            <div style="margin-top: 30px; display: flex; gap: 12px;">
                <button type="submit" class="btn btn-gold">Perbarui Produk</button>
                <a href="/admin/products" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
