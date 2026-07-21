<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FurniNest</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/pages/admin.css') }}">
    @yield('extra_css')
</head>
<body class="d-flex">

<div class="sidebar d-flex flex-column flex-shrink-0 p-3 position-fixed">
    <a href="/admin/dashboard" class="d-block mb-3 mb-md-0 me-md-auto text-decoration-none w-100 text-center mt-3">
        <span class="sidebar-brand">FurniNest</span>
    </a>
    <hr class="text-white-50">
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="/admin/dashboard" class="nav-link rounded-0 py-3 {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="/admin/products" class="nav-link rounded-0 py-3 {{ Request::is('admin/products*') ? 'active' : '' }}">
                <i class="fas fa-couch"></i> Produk
            </a>
        </li>
        <li>
            <a href="/admin/orders" class="nav-link rounded-0 py-3 {{ Request::is('admin/orders*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i> Pesanan
            </a>
        </li>
        <li>
            <a href="/admin/users" class="nav-link rounded-0 py-3 {{ Request::is('admin/users*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Pelanggan
            </a>
        </li>
        <li>
            <a href="/home" class="nav-link rounded-0 py-3">
                <i class="fas fa-eye"></i> Lihat Website
            </a>
        </li>
    </ul>
    <hr class="text-white-50">
    <div>
        <a href="/logout" class="d-flex align-items-center text-danger text-decoration-none px-3 py-2">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
    </div>
</div>

<div class="admin-content" style="margin-left: 280px;">
    <header class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold mb-0">@yield('header_title', 'Dashboard')</h1>
        <div class="d-flex align-items-center gap-3">
            <div class="user-avatar">{{ substr(session('currentUser')->name ?? 'A', 0, 1) }}</div>
            <div class="fw-bold">{{ session('currentUser')->name ?? 'Admin' }}</div>
        </div>
    </header>

    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    @yield('content')
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
