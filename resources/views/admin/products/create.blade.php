@extends('admin.layout')

@section('header_title', 'Tambah Produk Baru')

@section('content')
<div class="content-card" style="max-width: 800px;">
    <div class="card-header">
        <h3>Informasi Produk</h3>
    </div>
    <div style="padding: 30px;">
        <form action="/admin/products" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <div class="form-group">
                    <label>Nama Produk</label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: Kursi Kayu Jati" required>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="category" class="form-control" required>
                        <option value="Kursi">Kursi</option>
                        <option value="Meja">Meja</option>
                        <option value="Sofa">Sofa</option>
                        <option value="Lemari">Lemari</option>
                        <option value="Tempat Tidur">Tempat Tidur</option>
                        <option value="Dekorasi">Dekorasi</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Harga (Rp)</label>
                    <input type="number" name="price" class="form-control" placeholder="1000000" required>
                </div>
                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" name="stock" class="form-control" placeholder="10" required>
                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <label>Gambar Produk</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Jelaskan detail produk..."></textarea>
                </div>
                <div class="form-group">
                    <label>Material</label>
                    <input type="text" name="material" class="form-control" placeholder="Contoh: Kayu Mahoni, Velvet">
                </div>
                <div class="form-group">
                    <label>Warna Dasar</label>
                    <select name="color" class="form-control">
                        <option value="">-- Pilih Warna Dasar --</option>
                        <option value="Natural">Natural</option>
                        <option value="Walnut">Walnut</option>
                        <option value="Olive">Olive</option>
                        <option value="Beige">Beige</option>
                        <option value="Charcoal">Charcoal</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Dimensi</label>
                    <input type="text" name="dimensions" class="form-control" placeholder="Contoh: 120 x 60 x 75 cm">
                </div>
            </div>
            
            <div style="margin-top: 30px; display: flex; gap: 12px;">
                <button type="submit" class="btn btn-gold">Simpan Produk</button>
                <a href="/admin/products" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
