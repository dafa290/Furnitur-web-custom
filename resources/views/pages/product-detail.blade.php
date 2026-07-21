@extends('layouts.app')

@section('title', 'FurniNest | Detail Produk')

@section('extra_css')
    <!-- Bootstrap CSS for Product Detail Page -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/pages/product-detail.css') }}">
@endsection

@section('content')
<div class="container py-5 mt-5">
    <div class="mb-4">
        <a href="/home" class="back-link d-inline-flex align-items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    
    <div class="card border-0 shadow-lg" style="border-radius: 24px; overflow: hidden;">
        <div class="row g-0">
            <div class="col-md-6 bg-warm-white p-4 p-md-5 d-flex align-items-center justify-content-center">
                <img id="productImage" src="{{ $product->img ?? 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=600&fit=crop' }}" class="img-fluid rounded-4 shadow-sm" alt="{{ $product->name ?? 'Product Image' }}" style="max-height: 500px; object-fit: cover; width: 100%;">
            </div>
            <div class="col-md-6 p-4 p-md-5">
                <span class="badge bg-cream text-gold rounded-pill px-3 py-2 mb-3" id="productCategory" style="font-weight: 600; letter-spacing: 1px;">{{ $product->category ?? 'Furniture' }}</span>
                <h1 id="productName" class="display-5 fw-bold text-brown mb-3" style="font-family: 'Playfair Display', serif;">{{ $product->name ?? 'Memuat...' }}</h1>
                
                <div class="d-flex align-items-center gap-2 mb-4">
                    <span class="text-warning" id="productStars" style="letter-spacing: 2px;">★★★★½</span>
                    <span class="text-muted small" id="productRatingText">4.7 / 5 (24 ulasan)</span>
                </div>
                
                <div class="fs-1 fw-bolder text-gold mb-4" id="productPrice">Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}</div>
                
                <div class="product-description text-secondary mb-4 border-start border-3 border-light ps-3 lh-lg" id="productDescription">
                    {{ $product->description ?? 'Produk furnitur berkualitas tinggi dengan desain eksklusif yang akan mempercantik setiap sudut ruangan Anda. Dibuat dengan material pilihan untuk ketahanan maksimal.' }}
                </div>
                
                <div class="card bg-warm-white border-light mb-4" style="border-radius: 16px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between py-2 border-bottom border-light">
                            <span class="fw-semibold text-brown">Warna</span>
                            <span class="text-muted" id="productColor">{{ $product->color ?? '-' }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom border-light">
                            <span class="fw-semibold text-brown">Bahan</span>
                            <span class="text-muted" id="productMaterial">{{ $product->material ?? '-' }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-2">
                            <span class="fw-semibold text-brown">Dimensi</span>
                            <span class="text-muted" id="productDimensions">80cm x 60cm x 45cm</span>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4" id="stockStatus">
                    @if(($product->stock ?? 0) > 10)
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 fw-medium"><i class="fas fa-check-circle me-1"></i> Stok tersedia ({{ $product->stock }} pcs)</span>
                    @elseif(($product->stock ?? 0) > 0)
                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2 fw-medium"><i class="fas fa-exclamation-triangle me-1"></i> Stok terbatas ({{ $product->stock }} pcs)</span>
                    @else
                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2 fw-medium"><i class="fas fa-times-circle me-1"></i> Stok habis</span>
                    @endif
                </div>
                
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="input-group border rounded-pill overflow-hidden" style="width: 130px; height: 50px;">
                        <button class="btn btn-light border-0 text-gold fw-bold px-3" type="button" onclick="decrementQty()">−</button>
                        <input type="number" id="quantity" class="form-control border-0 text-center fw-bold bg-white" value="1" min="1" max="99" readonly>
                        <button class="btn btn-light border-0 text-gold fw-bold px-3" type="button" onclick="incrementQty({{ $product->stock ?? 99 }})">+</button>
                    </div>
                    <button class="btn btn-primary-custom flex-grow-1 rounded-pill fw-bold" style="height: 50px;" onclick="addToCartDetailPage({{ $product->id ?? 0 }})">
                        <i class="fas fa-shopping-cart me-2"></i> Tambah ke Keranjang
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_js')
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/pages/product-detail.js') }}"></script>
@endsection
