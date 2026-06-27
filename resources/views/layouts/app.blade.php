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
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script defer src="{{ asset('js/script.js') }}"></script>
</head>
<body>

<div class="navbar">
    <div class="container nav-inner">
        <div class="logo" onclick="window.location.href='/home'"><h1>FurniNest</h1></div>
        <div class="nav-menu">
            <a href="/home">Beranda</a>
            <a href="/custom">Custom</a>
            <a href="#productsSection">Produk</a>
            <a href="#categorySection">Kategori</a>
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
        </div>
    </div>
    <div id="navbarSearchBar" style="display: none; padding: 12px 32px 20px;">
        <input type="text" id="navbarSearchInput" class="search-input" placeholder="Cari furniture...">
    </div>
</div>

<main class="main-content">
    @yield('content')
</main>

<footer class="footer" id="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col"><h4>FurniNest</h4><p>Furniture premium dengan kualitas terbaik dan desain timeless untuk hunian impian Anda.</p></div>
            <div class="footer-col"><h4>Navigasi</h4><a href="/home">Beranda</a><a href="#productsSection">Produk</a><a href="#categorySection">Kategori</a><a href="#footer">Kontak</a></div>
            <div class="footer-col"><h4>Kontak</h4><p>📞 +62 812 3456 7890</p><p>✉️ hello@furninest.com</p><p>📍 Jakarta, Indonesia</p></div>
            <div class="footer-col"><h4>Ikuti Kami</h4><div class="social-icons"><i class="fab fa-instagram" onclick="showSocialNotification('Instagram')"></i><i class="fab fa-pinterest" onclick="showSocialNotification('Pinterest')"></i><i class="fab fa-facebook-f" onclick="showSocialNotification('Facebook')"></i></div></div>
        </div>
        <div class="copyright">© 2025 FurniNest — Premium Furniture for Spaces with Character</div>
    </div>
</footer>

<div id="toastMsg" class="toast-notif">Ditambahkan ke keranjang</div>

</body>
</html>
