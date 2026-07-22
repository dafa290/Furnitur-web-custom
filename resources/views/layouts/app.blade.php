<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="referrer" content="no-referrer">
    <title>@yield('title', 'FurniNest | Premium Furniture')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script defer src="{{ asset('js/script.js') }}"></script>
    @yield('extra_css')
</head>
<body>

<div class="navbar">
    <div class="container nav-inner">
        <div class="logo" onclick="window.location.href='/home'"><h1>FurniNest</h1></div>
        <div class="nav-menu">
            <a href="/home">Beranda</a>
            <a href="/custom">Custom</a>
            <a href="/home#productsSection">Produk</a>
            <a href="/home#categorySection">Kategori</a>
            <a href="#footer">Kontak</a>
            
            @if(!session('currentUser'))
                <a href="/login">Login</a>
                <a href="/register">Daftar</a>
            @else
                <div style="position: relative;">
                    <span class="nav-user-name" onclick="toggleDropdown()">👤 {{ session('currentUser')->name }} <i class="fas fa-chevron-down" style="font-size: 10px;"></i></span>
                    <div id="profileDropdown" class="dropdown-content" style="display: none;">
                        @if(session('currentUser')->role === 'ADMIN')
                            <a href="/admin/dashboard" style="color: var(--gold); font-weight: 700;"><i class="fas fa-chart-line"></i> Dashboard Admin</a>
                            <hr>
                        @endif
                        <a href="/profile?tab=profile"><i class="fas fa-user"></i> Informasi Akun</a>
                        <a href="/alamat/manage"><i class="fas fa-map-marker-alt"></i> Alamat Saya</a>
                        <a href="/profile?tab=orders"><i class="fas fa-box"></i> Riwayat Pesanan</a>
                        <a href="/profile?tab=wishlist"><i class="fas fa-heart"></i> Wishlist</a>
                        <a href="/profile?tab=password"><i class="fas fa-lock"></i> Ganti Password</a>
                        <hr>
                        <a href="/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            @endif
        </div>
        <div class="nav-icons">
            <i class="fas fa-search" onclick="toggleSearchBar()"></i>
            <div style="position: relative;">
                <i class="fas fa-shopping-bag" onclick="window.location.href='/checkout'"></i>
                <span class="cart-badge" id="cartBadge" style="display: none;">0</span>
            </div>
            <i class="fas fa-bars mobile-menu-btn" onclick="toggleMobileSidebar()" style="display: none;"></i>
        </div>
    </div>
    <div id="navbarSearchBar" style="display: none; padding: 12px 32px 20px;">
        <input type="text" id="navbarSearchInput" class="search-input" placeholder="Cari furniture...">
    </div>
</div>

<!-- Mobile Sidebar Overlay -->
<div class="mobile-sidebar-overlay" id="mobileSidebarOverlay" onclick="toggleMobileSidebar()"></div>
<div class="mobile-sidebar" id="mobileSidebar">
    <div class="mobile-sidebar-header">
        <h2>FurniNest</h2>
        <i class="fas fa-times" onclick="toggleMobileSidebar()"></i>
    </div>
    <div class="mobile-sidebar-content">
        <a href="/home"><i class="fas fa-home"></i> Beranda</a>
        <a href="/custom"><i class="fas fa-hammer"></i> Custom</a>
        <a href="/home#productsSection" onclick="toggleMobileSidebar()"><i class="fas fa-couch"></i> Produk</a>
        <a href="/home#categorySection" onclick="toggleMobileSidebar()"><i class="fas fa-th-large"></i> Kategori</a>
        <a href="#footer" onclick="toggleMobileSidebar()"><i class="fas fa-phone"></i> Kontak</a>
        <hr>
        @if(!session('currentUser'))
            <a href="/login"><i class="fas fa-sign-in-alt"></i> Login</a>
            <a href="/register"><i class="fas fa-user-plus"></i> Daftar</a>
        @else
            <a href="/profile?tab=profile" style="color: var(--gold);"><i class="fas fa-user-circle"></i> {{ session('currentUser')->name }}</a>
            @if(session('currentUser')->role === 'ADMIN')
                <a href="/admin/dashboard"><i class="fas fa-chart-line"></i> Dashboard Admin</a>
            @endif
            <a href="/alamat/manage"><i class="fas fa-map-marker-alt"></i> Alamat Saya</a>
            <a href="/profile?tab=orders"><i class="fas fa-box"></i> Riwayat Pesanan</a>
            <a href="/logout" style="color: #dc2626;"><i class="fas fa-sign-out-alt"></i> Logout</a>
        @endif
    </div>
</div>

<main class="main-content">
    @yield('content')
</main>

<footer class="footer" id="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col"><h4>FurniNest</h4><p>Furniture premium dengan kualitas terbaik dan desain timeless untuk hunian impian Anda.</p></div>
            <div class="footer-col"><h4>Navigasi</h4><a href="/home">Beranda</a><a href="/home#productsSection">Produk</a><a href="/home#categorySection">Kategori</a><a href="#footer">Kontak</a></div>
            <div class="footer-col"><h4>Kontak</h4><p>📞 +62 812 3456 7890</p><p>✉️ hello@furninest.com</p><p>📍 Jakarta, Indonesia</p></div>
            <div class="footer-col"><h4>Ikuti Kami</h4><div class="social-icons"><i class="fab fa-instagram" onclick="showSocialNotification('Instagram')"></i><i class="fab fa-pinterest" onclick="showSocialNotification('Pinterest')"></i><i class="fab fa-facebook-f" onclick="showSocialNotification('Facebook')"></i></div></div>
        </div>
        <div class="copyright">© 2026 FurniNest — Premium Furniture for Spaces with Character</div>
    </div>
</footer>

<div id="toastMsg" class="toast-notif">Ditambahkan ke keranjang</div>

@yield('extra_js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmxc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
