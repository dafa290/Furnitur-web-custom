@extends('layouts.app')

@section('title', 'FurniNest | Premium Furniture')

@section('content')
<div class="container">
    <!-- Hero Section dengan Video -->
    <div class="hero">
        <div class="hero-content">
            <div class="hero-badge">✦ Koleksi 2025 ✦</div>
            <h1 class="hero-title">Temukan Furniture<br><em>Impian Anda</em></h1>
            <p class="hero-desc">Koleksi eksklusif dengan sentuhan hangat kayu natural dan desain kontemporer untuk ruang yang penuh karakter.</p>
            <button class="btn-primary" onclick="scrollToProducts()">Belanja Sekarang <i class="fas fa-arrow-right"></i></button>
            <div class="hero-stats">
                <div class="stat-item"><div class="stat-number">500+</div><div class="stat-label">Produk Premium</div></div>
                <div class="stat-item"><div class="stat-number">4.9★</div><div class="stat-label">Rating Pelanggan</div></div>
                <div class="stat-item"><div class="stat-number">Gratis</div><div class="stat-label">Ongkir JKT</div></div>
            </div>
        </div>
        <div class="hero-image">
            <video autoplay muted loop playsinline referrerpolicy="no-referrer">
                <source src="{{ asset('videos/furniture-preview.mp4') }}" type="video/mp4">
                Browser tidak mendukung video.
            </video>
        </div>
    </div>

    <!-- Category Section -->
    <div class="category-section" id="categorySection">
        <span class="section-eyebrow">Jelajahi</span>
        <h2 class="section-title">Koleksi Unggulan</h2>
        <div class="category-scroll" id="categoryScroll">
            <div class="cat-card" data-cat="Kursi" onclick="filterByCategory('Kursi')"><div class="cat-icon"><i class="fas fa-couch"></i></div><span>Kursi</span></div>
            <div class="cat-card" data-cat="Meja" onclick="filterByCategory('Meja')"><div class="cat-icon"><i class="fas fa-table"></i></div><span>Meja</span></div>
            <div class="cat-card" data-cat="Sofa" onclick="filterByCategory('Sofa')"><div class="cat-icon"><i class="fas fa-couch"></i></div><span>Sofa</span></div>
            <div class="cat-card" data-cat="Lemari" onclick="filterByCategory('Lemari')"><div class="cat-icon"><i class="fas fa-archive"></i></div><span>Lemari</span></div>
            <div class="cat-card" data-cat="Tempat Tidur" onclick="filterByCategory('Tempat Tidur')"><div class="cat-icon"><i class="fas fa-bed"></i></div><span>Tempat Tidur</span></div>
        </div>
    </div>

    <!-- Carousel Iklan Section -->
    <div class="promo-section" id="carouselSection">
        <span class="section-eyebrow">✦ Promo Spesial ✦</span>
        <h2 class="section-title">Penawaran <em>Terbatas</em></h2>
        <div class="carousel-container">
            <div class="carousel-wrapper">
                <div class="carousel-slides-ads" id="carouselSlides">
                    <div class="carousel-slide-ad active">
                        <div class="carousel-content">
                            <div class="carousel-badge">🔥 HOT DEAL</div>
                            <h3>Diskon 30% untuk Sofa Premium</h3>
                            <p>Koleksi sofa terbaru dengan pilihan warna hangat dan bahan lembut untuk ruang tamu elegan.</p>
                            <button class="btn-primary" onclick="scrollToProducts()">Lihat Promo <i class="fas fa-arrow-right"></i></button>
                        </div>
                        <div class="carousel-image"><img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=400&h=300&fit=crop" alt="Sofa Promo"></div>
                    </div>
                    <div class="carousel-slide-ad">
                        <div class="carousel-content">
                            <div class="carousel-badge">🚚 GRATIS ONGKIR</div>
                            <h3>Gratis Antar & Pasang</h3>
                            <p>Nikmati layanan antar dan pemasangan gratis untuk setiap pembelian di atas Rp 2.000.000.</p>
                            <button class="btn-primary" onclick="scrollToProducts()">Belanja Sekarang <i class="fas fa-arrow-right"></i></button>
                        </div>
                        <div class="carousel-image"><img src="https://images.unsplash.com/photo-1618220179428-22790b461013?w=400&h=300&fit=crop" alt="Free Delivery"></div>
                    </div>
                    <div class="carousel-slide-ad">
                        <div class="carousel-content">
                            <div class="carousel-badge">🎨 DESAIN EKSKLUSIF</div>
                            <h3>Interior Styling Gratis</h3>
                            <p>Dapatkan konsultasi desain interior gratis untuk membuat rumah Anda lebih hidup dan berkelas.</p>
                            <button class="btn-primary" onclick="scrollToProducts()">Konsultasi <i class="fas fa-arrow-right"></i></button>
                        </div>
                        <div class="carousel-image"><img src="https://wallpaperaccess.com/full/2594902.jpg" alt="Interior Design"></div>
                    </div>
                    <div class="carousel-slide-ad">
                        <div class="carousel-content">
                            <div class="carousel-badge">🪑 KOLEKSI BARU</div>
                            <h3>Meja & Kursi Premium</h3>
                            <p>Kombinasi meja elegan dan kursi nyaman untuk ruang makan impian Anda.</p>
                            <button class="btn-primary" onclick="scrollToProducts()">Jelajahi <i class="fas fa-arrow-right"></i></button>
                        </div>
                        <div class="carousel-image"><img src="https://images.unsplash.com/photo-1533090481720-856c6e3c1fdc?w=400&h=300&fit=crop" alt="Dining Set"></div>
                    </div>
                    <div class="carousel-slide-ad">
                        <div class="carousel-content">
                            <div class="carousel-badge">⭐ 4.9★ RATING</div>
                            <h3>Kepuasan Pelanggan #1</h3>
                            <p>Bergabung dengan 500+ pelanggan puas yang telah mempercayakan furnitur impian mereka.</p>
                            <button class="btn-primary" onclick="scrollToProducts()">Lihat Testimoni <i class="fas fa-arrow-right"></i></button>
                        </div>
                        <div class="carousel-image"><img src="https://images.unsplash.com/photo-1505693314120-0d443867891c?w=400&h=300&fit=crop" alt="Customer Review"></div>
                    </div>
                </div>
                <button class="carousel-prev-ad" onclick="prevSlideAd()">❮</button>
                <button class="carousel-next-ad" onclick="nextSlideAd()">❯</button>
                <div class="carousel-dots-ad" id="carouselDotsAd">
                    <span class="dot-ad active" onclick="goToSlideAd(0)"></span>
                    <span class="dot-ad" onclick="goToSlideAd(1)"></span>
                    <span class="dot-ad" onclick="goToSlideAd(2)"></span>
                    <span class="dot-ad" onclick="goToSlideAd(3)"></span>
                    <span class="dot-ad" onclick="goToSlideAd(4)"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <div class="products-section" id="productsSection">
        <span class="section-eyebrow">Koleksi Lengkap</span>
        <h2 class="section-title">Semua Produk Furniture</h2>
        <div class="layout-dual">
            <aside class="filter-sidebar">
                <div class="filter-group">
                    <div class="filter-label">Cari Produk</div>
                    <input type="text" id="searchInput" class="search-input" placeholder="Cari furniture...">
                </div>
                <hr class="divider">
                <div class="filter-group">
                    <div class="filter-label">Kategori <span class="reset-link" id="resetCategory">reset</span></div>
                    <div class="cat-filter-list" id="categoryFilter">
                        <label class="cat-filter-item"><input type="checkbox" value="Kursi"> Kursi</label>
                        <label class="cat-filter-item"><input type="checkbox" value="Meja"> Meja</label>
                        <label class="cat-filter-item"><input type="checkbox" value="Sofa"> Sofa</label>
                        <label class="cat-filter-item"><input type="checkbox" value="Lemari"> Lemari</label>
                        <label class="cat-filter-item"><input type="checkbox" value="Tempat Tidur"> Tempat Tidur</label>
                    </div>
                </div>
                <hr class="divider">
                <div class="filter-group">
                    <div class="filter-label">Harga <span class="reset-link" id="resetPrice">reset</span></div>
                    <input type="range" id="priceSlider" class="price-slider" min="0" max="25000000" step="500000" value="25000000">
                    <div class="price-values"><span>Rp 0</span><span id="maxPriceLabel">Rp 25.000.000+</span></div>
                </div>
                <hr class="divider">
                <div class="filter-group">
                    <div class="filter-label">Warna</div>
                    <div class="swatch-group" id="swatchContainer">
                        <div class="swatch" data-color="Natural" style="background: #D9C5B2;" onclick="filterByColor('Natural')" title="Natural"></div>
                        <div class="swatch" data-color="Walnut" style="background: #6B4F3C;" onclick="filterByColor('Walnut')" title="Walnut"></div>
                        <div class="swatch" data-color="Olive" style="background: #8F9E7C;" onclick="filterByColor('Olive')" title="Olive"></div>
                        <div class="swatch" data-color="Beige" style="background: #F2E3D5;" onclick="filterByColor('Beige')" title="Beige"></div>
                        <div class="swatch" data-color="Charcoal" style="background: #4A4A48;" onclick="filterByColor('Charcoal')" title="Charcoal"></div>
                    </div>
                </div>
                <hr class="divider">
                <div class="filter-group">
                    <div class="filter-label">Bahan</div>
                    <div class="material-options" id="materialFilter">
                        <label class="material-opt"><input type="checkbox" value="Kayu"> Kayu</label>
                        <label class="material-opt"><input type="checkbox" value="Metal"> Metal</label>
                        <label class="material-opt"><input type="checkbox" value="Fabric"> Fabric</label>
                    </div>
                </div>
            </aside>
            <div class="product-grid" id="productGrid"></div>
        </div>
    </div>
</div>
@endsection
