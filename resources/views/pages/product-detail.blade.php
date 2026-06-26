@extends('layouts.app')

@section('title', 'FurniNest | Detail Produk')

@section('content')
<div class="container">
    <a href="/home" class="back-button">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
    
    <div class="product-detail-card" id="productDetailCard">
        <div class="product-gallery">
            <img id="productImage" src="{{ $product->img ?? 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=600&fit=crop' }}" alt="{{ $product->name ?? 'Product Image' }}">
        </div>
        <div class="product-info">
            <span class="product-category" id="productCategory">{{ $product->category ?? 'Furniture' }}</span>
            <h1 id="productName">{{ $product->name ?? 'Memuat...' }}</h1>
            <div class="product-rating">
                <span class="stars" id="productStars">★★★★½</span>
                <span class="rating-text" id="productRatingText">4.7 / 5 (24 ulasan)</span>
            </div>
            <div class="product-price" id="productPrice">Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}</div>
            <div class="product-description" id="productDescription">
                {{ $product->description ?? 'Produk furnitur berkualitas tinggi dengan desain eksklusif yang akan mempercantik setiap sudut ruangan Anda. Dibuat dengan material pilihan untuk ketahanan maksimal.' }}
            </div>
            
            <div class="specs-grid">
                <div class="spec-row">
                    <span class="spec-label">Warna</span>
                    <span class="spec-value" id="productColor">{{ $product->color ?? '-' }}</span>
                </div>
                <div class="spec-row">
                    <span class="spec-label">Bahan</span>
                    <span class="spec-value" id="productMaterial">{{ $product->material ?? '-' }}</span>
                </div>
                <div class="spec-row">
                    <span class="spec-label">Dimensi</span>
                    <span class="spec-value" id="productDimensions">80cm x 60cm x 45cm</span>
                </div>
            </div>
            
            <div id="stockStatus">
                @if(($product->stock ?? 0) > 10)
                    <div class="stock-status in-stock"><i class="fas fa-check-circle"></i> Stok tersedia ({{ $product->stock }} pcs)</div>
                @elseif(($product->stock ?? 0) > 0)
                    <div class="stock-status low-stock"><i class="fas fa-exclamation-triangle"></i> Stok terbatas ({{ $product->stock }} pcs)</div>
                @else
                    <div class="stock-status out-stock"><i class="fas fa-times-circle"></i> Stok habis</div>
                @endif
            </div>
            
            <div class="cart-section">
                <div class="quantity-wrapper">
                    <button class="qty-btn" onclick="decrementQty()">−</button>
                    <input type="number" id="quantity" class="qty-input" value="1" min="1" max="99" readonly>
                    <button class="qty-btn" onclick="incrementQty()">+</button>
                </div>
                <button class="btn-add-cart" onclick="addToCartDetailPage()">
                    <i class="fas fa-shopping-cart"></i> Tambah ke Keranjang
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Specific styles for product detail since they differ slightly from main home page */
    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin: 32px 0 24px;
        text-decoration: none;
        color: var(--brown-light);
        font-weight: 500;
        transition: gap 0.2s;
    }
    .back-button:hover { gap: 12px; color: var(--gold); }
    
    .product-detail-card {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 48px;
        background: white;
        border-radius: 32px;
        overflow: hidden;
        box-shadow: var(--shadow);
        margin-bottom: 60px;
    }
    .product-gallery {
        background: var(--warm-white);
        padding: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .product-gallery img {
        width: 100%;
        max-width: 400px;
        border-radius: 24px;
        object-fit: cover;
        transition: transform 0.3s;
    }
    .product-info { padding: 48px 48px 48px 0; }
    .product-category {
        display: inline-block;
        background: var(--cream);
        color: var(--gold-dark);
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 16px;
    }
    .product-info h1 { font-family: 'Playfair Display', serif; font-size: 36px; font-weight: 700; color: var(--brown); margin-bottom: 12px; }
    .product-rating { display: flex; align-items: center; gap: 8px; margin-bottom: 20px; }
    .stars { color: #f5b042; letter-spacing: 2px; }
    .rating-text { color: var(--text-light); font-size: 14px; }
    .product-price { font-size: 32px; font-weight: 800; color: var(--gold-dark); margin-bottom: 24px; }
    .product-description { color: var(--text-dark); line-height: 1.7; margin-bottom: 28px; border-left: 3px solid var(--border-light); padding-left: 20px; }
    .specs-grid { background: var(--warm-white); border-radius: 20px; padding: 20px; margin-bottom: 28px; border: 1px solid var(--border-light); }
    .spec-row { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--border-light); }
    .spec-row:last-child { border-bottom: none; }
    .spec-label { font-weight: 600; color: var(--brown); }
    .spec-value { color: var(--text-light); }
    .stock-status { display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 30px; font-size: 13px; font-weight: 500; margin-bottom: 24px; }
    .in-stock { background: #e8f3ec; color: #2e7d32; }
    .low-stock { background: #fff3e0; color: #ed6c02; }
    .out-stock { background: #ffebee; color: #d32f2f; }
    .cart-section { display: flex; align-items: center; gap: 20px; flex-wrap: wrap; }
    .quantity-wrapper { display: flex; align-items: center; border: 1px solid var(--border-light); border-radius: 60px; overflow: hidden; }
    .qty-btn { width: 44px; height: 44px; background: white; border: none; font-size: 20px; cursor: pointer; color: var(--gold); transition: background 0.2s; }
    .qty-btn:hover { background: var(--warm-white); }
    .qty-input { width: 60px; text-align: center; border: none; font-size: 16px; font-weight: 500; background: white; padding: 10px 0; }
    .btn-add-cart { flex: 1; background: var(--brown); border: none; padding: 14px 28px; border-radius: 60px; color: white; font-weight: 700; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; transition: all 0.2s; }
    .btn-add-cart:hover { background: var(--gold); transform: translateY(-2px); }

    @media (max-width: 768px) {
        .product-detail-card { grid-template-columns: 1fr; gap: 0; }
        .product-info { padding: 32px; }
    }
</style>

<script>
    function incrementQty() {
        const input = document.getElementById('quantity');
        let val = parseInt(input.value);
        if (val < {{ $product->stock ?? 99 }}) input.value = val + 1;
        else showToast('Stok tidak mencukupi');
    }
    function decrementQty() {
        const input = document.getElementById('quantity');
        let val = parseInt(input.value);
        if (val > 1) input.value = val - 1;
    }
    function addToCartDetailPage() {
        const qty = parseInt(document.getElementById('quantity').value);
        const productId = {{ $product->id ?? 0 }};
        if (productId === 0) return;
        
        // Pass quantity directly to addToCart
        window.addToCart(productId, qty);
    }
</script>
@endsection
