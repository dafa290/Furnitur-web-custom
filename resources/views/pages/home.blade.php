@extends('layouts.app')

@section('title', 'FurniNest | Premium Furniture')

@section('extra_css')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/home-lama.css') }}">
<link rel="stylesheet" href="{{ asset('css/pages/home.css') }}">
@endsection

@section('content')
<!-- ========== HERO SECTION ========== -->
<section class="hero" id="home-page">
    <div class="hero-bg" style="background-image: url('{{ asset('assets/images/hero/bg-hero.jpg') }}');"></div>
    <div class="hero-content">
        <div class="hero-text" data-aos="fade-up" data-aos-duration="1000">
            <span class="hero-badge">✦ Limited Edition ✦</span>
            <h1>Elevate Your<br>Living Space</h1>
            <p style="color: white !important;">Discover luxury furniture that combines timeless elegance with modern comfort. Crafted for those who appreciate the finer things in life.</p>
            <div class="hero-buttons">
                <button class="btn-primary" onclick="window.location.href='/home#productsSection'">Shop Collection →</button>
                <button class="btn-outline" onclick="document.getElementById('featured').scrollIntoView({behavior: 'smooth'})">Explore Now</button>
            </div>
            <div class="hero-stats" style="color: white !important;">
                <div><span style="color: white !important;">500+</span><br>Premium Products</div>
                <div><span style="color: white !important;">15k+</span><br>Happy Customers</div>
                <div><span style="color: white !important;">4.9</span><br>Rating</div>
            </div>
        </div>
        <div class="hero-gallery" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
            <div class="hero-card hero-card-1">
                <img src="{{ asset('assets/images/hero/hero-1.jpg') }}" alt="Luxury Sofa" onerror="this.src='https://placehold.co/400x500?text=Hero+1'">
                <div class="hero-card-label">Nordic Sofa</div>
            </div>
            <div class="hero-card hero-card-2">
                <img src="{{ asset('assets/images/hero/hero-2.jpg') }}" alt="Designer Chair" onerror="this.src='https://placehold.co/400x500?text=Hero+2'">
                <div class="hero-card-label">Eames Chair</div>
            </div>
            <div class="hero-card hero-card-3">
                <img src="{{ asset('assets/images/hero/hero-3.jpg') }}" alt="Modern Cabinet" onerror="this.src='https://placehold.co/400x500?text=Hero+3'">
                <div class="hero-card-label">Statement Piece</div>
            </div>
            <div class="promo-banner">
                <div class="promo-content">
                    <div class="promo-text">
                        <span class="promo-badge">Limited Offer</span>
                        <h2>Luxury</h2>
                        <h3>-40% OFF</h3>
                    </div>
                    <div class="promo-image-wrapper">
                        <div class="promo-image">
                            <img src="{{ asset('assets/images/promo/promo.jpg') }}" alt="Promo" onerror="this.src='https://placehold.co/100x100?text=Promo'">
                        </div>
                        <div class="promo-discount-badge">-40%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========== CATEGORIES SECTION ========== -->
<section class="categories" data-aos="fade-up" id="categorySection">
    <div class="section-header">
        <span class="section-subtitle">Koleksi</span>
        <h2 class="section-title">Shop by Category</h2>
        <div class="section-line"></div>
    </div>
    <div class="category-grid" id="categoryGrid">
        <div class="category-item" onclick="window.location.href='/home#productsSection'">
            <div class="category-icon"><i class="fas fa-couch"></i></div>
            <h3>Sofa & Kursi</h3>
        </div>
        <div class="category-item" onclick="window.location.href='/home#productsSection'">
            <div class="category-icon"><i class="fas fa-bed"></i></div>
            <h3>Tempat Tidur</h3>
        </div>
        <div class="category-item" onclick="window.location.href='/home#productsSection'">
            <div class="category-icon"><i class="fas fa-table"></i></div>
            <h3>Meja</h3>
        </div>
        <div class="category-item" onclick="window.location.href='/home#productsSection'">
            <div class="category-icon"><i class="fas fa-archive"></i></div>
            <h3>Lemari & Rak</h3>
        </div>
    </div>
</section>


<!-- ========== PRODUCTS SECTION (Koleksi Lengkap dari DB Project) ========== -->
<div class="container my-5 pt-4" id="productsSection">
    <div class="text-center mb-5">
        <span class="text-uppercase fw-bold" style="color: var(--gold); font-size: 0.8rem; letter-spacing: 3px;">Koleksi Lengkap</span>
        <h2 class="display-5 fw-bold mb-3">Semua Produk Furniture</h2>
        <div class="mx-auto rounded" style="width: 60px; height: 3px; background: var(--gold);"></div>
    </div>
    
    <div class="row g-5">
        <aside class="col-lg-3">
            <div class="bg-white rounded-4 p-4 shadow-sm sticky-top" style="top: 92px;">
                <div class="mb-4">
                    <div class="text-uppercase fw-bold mb-3" style="font-size: 12px; letter-spacing: 1px;">Cari Produk</div>
                    <input type="text" id="searchInput" class="form-control rounded-3 bg-light border-0 py-2 px-3" placeholder="Cari furniture...">
                </div>
                <hr class="text-muted opacity-25 my-4">
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-uppercase fw-bold" style="font-size: 12px; letter-spacing: 1px;">Kategori</span>
                        <span class="text-muted" id="resetCategory" style="font-size: 10px; cursor: pointer;">reset</span>
                    </div>
                    <div class="d-flex flex-column gap-2" id="categoryFilter">
                        <label class="d-flex align-items-center gap-2" style="font-size: 14px; cursor: pointer;"><input type="checkbox" value="Kursi" class="form-check-input mt-0" style="accent-color: #C6A15B;"> Kursi</label>
                        <label class="d-flex align-items-center gap-2" style="font-size: 14px; cursor: pointer;"><input type="checkbox" value="Meja" class="form-check-input mt-0" style="accent-color: #C6A15B;"> Meja</label>
                        <label class="d-flex align-items-center gap-2" style="font-size: 14px; cursor: pointer;"><input type="checkbox" value="Sofa" class="form-check-input mt-0" style="accent-color: #C6A15B;"> Sofa</label>
                        <label class="d-flex align-items-center gap-2" style="font-size: 14px; cursor: pointer;"><input type="checkbox" value="Lemari" class="form-check-input mt-0" style="accent-color: #C6A15B;"> Lemari</label>
                        <label class="d-flex align-items-center gap-2" style="font-size: 14px; cursor: pointer;"><input type="checkbox" value="Tempat Tidur" class="form-check-input mt-0" style="accent-color: #C6A15B;"> Tempat Tidur</label>
                    </div>
                </div>
                <hr class="text-muted opacity-25 my-4">
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-uppercase fw-bold" style="font-size: 12px; letter-spacing: 1px;">Harga</span>
                        <span class="text-muted" id="resetPrice" style="font-size: 10px; cursor: pointer;">reset</span>
                    </div>
                    <input type="range" id="priceSlider" class="form-range" min="0" max="25000000" step="500000" value="25000000" style="accent-color: #C6A15B;">
                    <div class="d-flex justify-content-between text-muted mt-2" style="font-size: 12px;"><span>Rp 0</span><span id="maxPriceLabel">Rp 25.000.000+</span></div>
                </div>
                <hr class="text-muted opacity-25 my-4">
                <div class="mb-4">
                    <div class="text-uppercase fw-bold mb-3" style="font-size: 12px; letter-spacing: 1px;">Warna</div>
                    <div class="d-flex gap-2 flex-wrap" id="swatchContainer">
                        <div class="swatch rounded-circle border" data-color="Natural" style="background: #D9C5B2; width: 32px; height: 32px; cursor: pointer;" onclick="filterByColor('Natural')" title="Natural"></div>
                        <div class="swatch rounded-circle border" data-color="Walnut" style="background: #6B4F3C; width: 32px; height: 32px; cursor: pointer;" onclick="filterByColor('Walnut')" title="Walnut"></div>
                        <div class="swatch rounded-circle border" data-color="Olive" style="background: #8F9E7C; width: 32px; height: 32px; cursor: pointer;" onclick="filterByColor('Olive')" title="Olive"></div>
                        <div class="swatch rounded-circle border" data-color="Beige" style="background: #F2E3D5; width: 32px; height: 32px; cursor: pointer;" onclick="filterByColor('Beige')" title="Beige"></div>
                        <div class="swatch rounded-circle border" data-color="Charcoal" style="background: #4A4A48; width: 32px; height: 32px; cursor: pointer;" onclick="filterByColor('Charcoal')" title="Charcoal"></div>
                    </div>
                </div>
                <hr class="text-muted opacity-25 my-4">
                <div class="mb-2">
                    <div class="text-uppercase fw-bold mb-3" style="font-size: 12px; letter-spacing: 1px;">Bahan</div>
                    <div class="d-flex flex-column gap-2" id="materialFilter">
                        <label class="d-flex align-items-center gap-2" style="font-size: 14px; cursor: pointer;"><input type="checkbox" value="Kayu" class="form-check-input mt-0" style="accent-color: #C6A15B;"> Kayu</label>
                        <label class="d-flex align-items-center gap-2" style="font-size: 14px; cursor: pointer;"><input type="checkbox" value="Metal" class="form-check-input mt-0" style="accent-color: #C6A15B;"> Metal</label>
                        <label class="d-flex align-items-center gap-2" style="font-size: 14px; cursor: pointer;"><input type="checkbox" value="Fabric" class="form-check-input mt-0" style="accent-color: #C6A15B;"> Fabric</label>
                    </div>
                </div>
            </div>
        </aside>
        
        <div class="col-lg-9">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="productGrid">
                <!-- Render by script.js via API -->
            </div>
        </div>
    </div>
</div>


@endsection

@section('extra_js')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="{{ asset('js/pages/home.js') }}"></script>
@endsection
