<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FurniNest</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --admin-dark: #1a1a1a;
            --admin-sidebar: #242424;
            --admin-gold: #C6A15B;
            --admin-bg: #f8f9fa;
            --admin-text: #333;
            --admin-border: #eee;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--admin-bg); color: var(--admin-text); display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: var(--admin-sidebar);
            color: white;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 100;
        }

        .sidebar-header {
            padding: 30px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .sidebar-header h2 {
            font-family: 'Playfair Display', serif;
            color: var(--admin-gold);
            font-size: 24px;
        }

        .sidebar-menu {
            padding: 20px 0;
            flex-grow: 1;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 14px 30px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.3s;
            font-size: 14px;
            font-weight: 500;
        }

        .menu-item i {
            width: 24px;
            margin-right: 12px;
            font-size: 18px;
        }

        .menu-item:hover, .menu-item.active {
            color: white;
            background: rgba(255,255,255,0.05);
            border-left: 4px solid var(--admin-gold);
        }

        .sidebar-footer {
            padding: 20px 30px;
            border-top: 1px solid rgba(255,255,255,0.05);
        }

        .logout-btn {
            color: #ff4d4d;
            text-decoration: none;
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        /* Main Content */
        .main-container {
            margin-left: 260px;
            flex-grow: 1;
            padding: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--admin-dark);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--admin-gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        /* Dashboard Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            border: 1px solid var(--admin-border);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 16px;
        }

        .stat-label { font-size: 14px; color: #777; margin-bottom: 4px; }
        .stat-value { font-size: 24px; font-weight: 700; color: var(--admin-dark); }

        /* Tables */
        .content-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            border: 1px solid var(--admin-border);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--admin-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h3 { font-size: 18px; font-weight: 600; }

        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 16px 24px; background: #fcfcfc; border-bottom: 1px solid var(--admin-border); font-size: 13px; font-weight: 600; color: #777; }
        td { padding: 16px 24px; border-bottom: 1px solid var(--admin-border); font-size: 14px; }
        tr:last-child td { border-bottom: none; }

        .badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-success { background: #e6f7ed; color: #00a854; }
        .badge-warning { background: #fff7e6; color: #fa8c16; }
        .badge-danger { background: #fff1f0; color: #f5222d; }
        .badge-info { background: #e6f7ff; color: #1890ff; }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
        }

        .btn-gold { background: var(--admin-gold); color: white; }
        .btn-gold:hover { background: #b08e4d; }
        .btn-sm { padding: 6px 12px; font-size: 12px; }
        .btn-outline { border: 1px solid var(--admin-gold); color: var(--admin-gold); background: transparent; }

        /* Forms */
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-size: 14px; font-weight: 500; }
        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--admin-border);
            border-radius: 8px;
            font-family: inherit;
            font-size: 14px;
        }
        .form-control:focus { outline: none; border-color: var(--admin-gold); }

        @media (max-width: 900px) {
            .sidebar { width: 80px; }
            .sidebar-header h2, .menu-item span, .sidebar-footer span { display: none; }
            .main-container { margin-left: 80px; }
        }
    </style>
    @yield('extra_css')
</head>
<body>

<div class="sidebar">
    <div class="sidebar-header">
        <h2>FurniNest</h2>
    </div>
    <nav class="sidebar-menu">
        <a href="/admin/dashboard" class="menu-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i>
            <span>Dashboard</span>
        </a>
        <a href="/admin/products" class="menu-item {{ Request::is('admin/products*') ? 'active' : '' }}">
            <i class="fas fa-couch"></i>
            <span>Produk</span>
        </a>
        <a href="/admin/orders" class="menu-item {{ Request::is('admin/orders*') ? 'active' : '' }}">
            <i class="fas fa-shopping-cart"></i>
            <span>Pesanan</span>
        </a>
        <a href="/admin/users" class="menu-item {{ Request::is('admin/users*') ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            <span>Pelanggan</span>
        </a>
        <a href="/home" class="menu-item">
            <i class="fas fa-eye"></i>
            <span>Lihat Website</span>
        </a>
    </nav>
    <div class="sidebar-footer">
        <a href="/logout" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>
</div>

<div class="main-container">
    <header class="header">
        <h1>@yield('header_title', 'Dashboard')</h1>
        <div class="user-info">
            <div class="user-avatar">{{ substr(session('currentUser')->name ?? 'A', 0, 1) }}</div>
            <div style="font-size: 14px; font-weight: 600;">{{ session('currentUser')->name ?? 'Admin' }}</div>
        </div>
    </header>

    @if(session('success'))
        <div style="background: #e6f7ed; color: #00a854; padding: 12px 20px; border-radius: 8px; margin-bottom: 24px; font-size: 14px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @yield('content')
</div>

</body>
</html>
