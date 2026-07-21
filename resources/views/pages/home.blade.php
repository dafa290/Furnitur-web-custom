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
            <p>Discover luxury furniture that combines timeless elegance with modern comfort. Crafted for those who appreciate the finer things in life.</p>
            <div class="hero-buttons">
                <button class="btn-primary" onclick="window.location.href='/home#productsSection'">Shop Collection →</button>
                <button class="btn-outline" onclick="document.getElementById('featured').scrollIntoView({behavior: 'smooth'})">Explore Now</button>
            </div>
            <div class="hero-stats">
                <div><span>500+</span><br>Premium Products</div>
                <div><span>15k+</span><br>Happy Customers</div>
                <div><span>4.9</span><br>Rating</div>
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
<div class="products-section" id="productsSection" style="max-width: 1280px; margin: 4rem auto 2rem; padding: 0 6%;">
    <div class="section-header" style="margin-bottom: 2rem;">
        <span class="section-subtitle" style="color: var(--gold); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 3px; font-weight: 600;">Koleksi Lengkap</span>
        <h2 class="section-title" style="font-size: 2.5rem; font-weight: 700; margin-bottom: 0.5rem;">Semua Produk Furniture</h2>
        <div class="section-line" style="width: 60px; height: 3px; background: var(--gold); margin: 1rem 0 0; border-radius: 3px;"></div>
    </div>
    
    <div class="layout-dual" style="display: grid; grid-template-columns: 260px 1fr; gap: 40px; align-items: start;">
        <aside class="filter-sidebar" style="background: white; border-radius: 24px; padding: 28px 24px; position: sticky; top: 92px; box-shadow: 0 20px 40px rgba(0,0,0,0.05); align-self: start;">
            <div class="filter-group">
                <div class="filter-label" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 14px;">Cari Produk</div>
                <input type="text" id="searchInput" class="search-input" placeholder="Cari furniture..." style="width: 100%; padding: 12px 16px; border: 1px solid #E8DFD5; border-radius: 16px; background: #FAF7F2; outline: none;">
            </div>
            <hr class="divider" style="border: none; border-top: 1px solid #E8DFD5; margin: 20px 0;">
            <div class="filter-group">
                <div class="filter-label" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 14px; display: flex; justify-content: space-between;">Kategori <span class="reset-link" id="resetCategory" style="font-size: 10px; color: #7A6B5D; cursor: pointer;">reset</span></div>
                <div class="cat-filter-list" id="categoryFilter" style="display: flex; flex-direction: column; gap: 12px;">
                    <label class="cat-filter-item" style="display: flex; align-items: center; gap: 10px; font-size: 14px; cursor: pointer;"><input type="checkbox" value="Kursi" style="accent-color: #C6A15B; width: 16px; height: 16px;"> Kursi</label>
                    <label class="cat-filter-item" style="display: flex; align-items: center; gap: 10px; font-size: 14px; cursor: pointer;"><input type="checkbox" value="Meja" style="accent-color: #C6A15B; width: 16px; height: 16px;"> Meja</label>
                    <label class="cat-filter-item" style="display: flex; align-items: center; gap: 10px; font-size: 14px; cursor: pointer;"><input type="checkbox" value="Sofa" style="accent-color: #C6A15B; width: 16px; height: 16px;"> Sofa</label>
                    <label class="cat-filter-item" style="display: flex; align-items: center; gap: 10px; font-size: 14px; cursor: pointer;"><input type="checkbox" value="Lemari" style="accent-color: #C6A15B; width: 16px; height: 16px;"> Lemari</label>
                    <label class="cat-filter-item" style="display: flex; align-items: center; gap: 10px; font-size: 14px; cursor: pointer;"><input type="checkbox" value="Tempat Tidur" style="accent-color: #C6A15B; width: 16px; height: 16px;"> Tempat Tidur</label>
                </div>
            </div>
            <hr class="divider" style="border: none; border-top: 1px solid #E8DFD5; margin: 20px 0;">
            <div class="filter-group">
                <div class="filter-label" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 14px; display: flex; justify-content: space-between;">Harga <span class="reset-link" id="resetPrice" style="font-size: 10px; color: #7A6B5D; cursor: pointer;">reset</span></div>
                <input type="range" id="priceSlider" class="price-slider" min="0" max="25000000" step="500000" value="25000000" style="width: 100%; accent-color: #C6A15B; cursor: pointer;">
                <div class="price-values" style="display: flex; justify-content: space-between; font-size: 12px; color: #7A6B5D; margin-top: 8px;"><span>Rp 0</span><span id="maxPriceLabel">Rp 25.000.000+</span></div>
            </div>
            <hr class="divider" style="border: none; border-top: 1px solid #E8DFD5; margin: 20px 0;">
            <div class="filter-group">
                <div class="filter-label" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 14px;">Warna</div>
                <div class="swatch-group" id="swatchContainer" style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <div class="swatch" data-color="Natural" style="background: #D9C5B2; width: 36px; height: 36px; border-radius: 50%; cursor: pointer; border: 2px solid transparent;" onclick="filterByColor('Natural')" title="Natural"></div>
                    <div class="swatch" data-color="Walnut" style="background: #6B4F3C; width: 36px; height: 36px; border-radius: 50%; cursor: pointer; border: 2px solid transparent;" onclick="filterByColor('Walnut')" title="Walnut"></div>
                    <div class="swatch" data-color="Olive" style="background: #8F9E7C; width: 36px; height: 36px; border-radius: 50%; cursor: pointer; border: 2px solid transparent;" onclick="filterByColor('Olive')" title="Olive"></div>
                    <div class="swatch" data-color="Beige" style="background: #F2E3D5; width: 36px; height: 36px; border-radius: 50%; cursor: pointer; border: 2px solid transparent;" onclick="filterByColor('Beige')" title="Beige"></div>
                    <div class="swatch" data-color="Charcoal" style="background: #4A4A48; width: 36px; height: 36px; border-radius: 50%; cursor: pointer; border: 2px solid transparent;" onclick="filterByColor('Charcoal')" title="Charcoal"></div>
                </div>
            </div>
            <hr class="divider" style="border: none; border-top: 1px solid #E8DFD5; margin: 20px 0;">
            <div class="filter-group">
                <div class="filter-label" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 14px;">Bahan</div>
                <div class="material-options" id="materialFilter" style="display: flex; flex-direction: column; gap: 10px;">
                    <label class="material-opt" style="display: flex; align-items: center; gap: 10px; font-size: 14px; cursor: pointer;"><input type="checkbox" value="Kayu" style="accent-color: #C6A15B;"> Kayu</label>
                    <label class="material-opt" style="display: flex; align-items: center; gap: 10px; font-size: 14px; cursor: pointer;"><input type="checkbox" value="Metal" style="accent-color: #C6A15B;"> Metal</label>
                    <label class="material-opt" style="display: flex; align-items: center; gap: 10px; font-size: 14px; cursor: pointer;"><input type="checkbox" value="Fabric" style="accent-color: #C6A15B;"> Fabric</label>
                </div>
            </div>
        </aside>
        
        <div class="product-grid" id="productGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 28px;">
            <!-- Render by script.js via API -->
        </div>
    </div>
</div>

<!-- ========== FOOTER (Lama) ========== -->
<footer class="footer" style="background: var(--dark); color: white; padding: 60px 0 30px; margin-top: 60px;">
    <div class="footer-container" style="max-width: 1200px; margin: 0 auto; padding: 0 6%;">
        <div class="footer-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem;">
            <div class="footer-col brand-col">
                <div class="footer-logo" style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1rem; color: #fff;">
                    <i class="fas fa-crown" style="color: var(--gold);"></i>
                    Furni<span style="color: var(--gold);">Rest</span>
                </div>
                <p class="footer-description" style="color: #aaa; margin-bottom: 1.5rem;">Premium luxury furniture that transforms your living space into a masterpiece of comfort and elegance.</p>
                <div class="social-links" style="display: flex; gap: 1rem;">
                    <a href="#" class="social-link" style="color: #fff; background: rgba(255,255,255,0.1); width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center;"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link" style="color: #fff; background: rgba(255,255,255,0.1); width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center;"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link" style="color: #fff; background: rgba(255,255,255,0.1); width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center;"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
            
            <div class="footer-col">
                <h4 style="color: var(--gold); margin-bottom: 1rem; font-weight: 700;">Quick Links</h4>
                <ul class="footer-links" style="list-style: none; padding: 0; color: #aaa;">
                    <li style="margin-bottom: 0.5rem;"><a href="/home" style="color: #aaa; text-decoration: none;">Home</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="/custom" style="color: #aaa; text-decoration: none;">Custom</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="/profile" style="color: #aaa; text-decoration: none;">My Account</a></li>
                </ul>
            </div>
            
            <div class="footer-col">
                <h4 style="color: var(--gold); margin-bottom: 1rem; font-weight: 700;">Contact Us</h4>
                <ul class="footer-contact" style="list-style: none; padding: 0; color: #aaa;">
                    <li style="margin-bottom: 0.5rem;"><i class="fas fa-map-marker-alt" style="margin-right: 0.5rem;"></i> Jl. Furniture Indah No. 88, Jakarta</li>
                    <li style="margin-bottom: 0.5rem;"><i class="fas fa-phone" style="margin-right: 0.5rem;"></i> +62 21 1234 5678</li>
                    <li style="margin-bottom: 0.5rem;"><i class="fas fa-envelope" style="margin-right: 0.5rem;"></i> info@furirest.com</li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom" style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1); text-align: center; color: #aaa; font-size: 0.9rem;">
            <p>&copy; 2025 FurniRest. All rights reserved. | Premium Luxury Furniture</p>
        </div>
    </div>
</footer>
@endsection

@section('extra_js')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="{{ asset('js/pages/home.js') }}"></script>
@endsection
