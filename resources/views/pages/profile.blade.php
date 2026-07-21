@extends('layouts.app')

@section('title', 'Profil Saya - FurniNest')

@section('extra_css')
<link rel="stylesheet" href="{{ asset('css/pages/profile.css') }}">
@endsection

@section('content')
<div class="profile-container">
    <div class="page-header">
        <div>
            <span class="welcome-badge"><i class="fas fa-user"></i> Akun Saya</span>
            <h1>Selamat datang, {{ $user->name }}</h1>
        </div>
        <button class="btn-action btn-outline" onclick="window.location.href='/logout'">
            <i class="fas fa-sign-out-alt"></i> Keluar
        </button>
    </div>

    <!-- Tabs -->
    <div class="profile-tabs">
        <a class="profile-tab {{ $tab == 'profile' ? 'active' : '' }}" href="/profile?tab=profile">
            <i class="fas fa-user"></i> Informasi Akun
        </a>
        <a class="profile-tab {{ $tab == 'address' ? 'active' : '' }}" href="/profile?tab=address">
            <i class="fas fa-map-marker-alt"></i> Alamat Saya
        </a>
        <a class="profile-tab {{ $tab == 'orders' ? 'active' : '' }}" href="/profile?tab=orders">
            <i class="fas fa-box"></i> Riwayat Pesanan
        </a>
        <a class="profile-tab {{ $tab == 'wishlist' ? 'active' : '' }}" href="/profile?tab=wishlist">
            <i class="fas fa-heart"></i> Wishlist
        </a>
        <a class="profile-tab {{ $tab == 'password' ? 'active' : '' }}" href="/profile?tab=password">
            <i class="fas fa-lock"></i> Ganti Password
        </a>
    </div>

    <!-- Tab: Informasi Akun -->
    @if($tab == 'profile')
    <div class="section-card">
        <h2><i class="fas fa-user-edit" style="color: var(--gold); margin-right: 10px;"></i> Informasi Akun</h2>
        <form id="accountForm" onsubmit="return saveAccountInfo(event)">
            <div class="profile-grid">
                <div>
                    <div class="profile-info-item">
                        <label>Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ $user->name }}" required>
                    </div>
                    <div class="profile-info-item">
                        <label>Email</label>
                        <input type="email" id="email" name="email" value="{{ $user->email }}" required>
                    </div>
                    <div class="profile-info-item">
                        <label>Nomor Telepon</label>
                        <input type="tel" id="phone" name="phone" value="{{ $user->phone }}" required>
                    </div>
                </div>
                <div>
                    <div class="info-text">
                        <i class="fas fa-info-circle" style="color: var(--gold);"></i>
                        <p style="margin-top: 8px;">Halo! Di halaman ini Anda dapat memperbarui data akun secara instan. Simpan setiap perubahan untuk memastikan profil Anda tetap akurat dan siap digunakan untuk pesanan selanjutnya.</p>
                    </div>
                    <button type="submit" class="btn-action">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
            <div id="profileMessage" style="margin-top: 20px;"></div>
        </form>
    </div>
    @endif

    <!-- Tab: Alamat Saya -->
    @if($tab == 'address')
    <div class="section-card">
        <h2><i class="fas fa-map-pin" style="color: var(--gold); margin-right: 10px;"></i> Alamat Saya</h2>
        <div class="addresses-list">
            @if($addresses->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-map-marker-alt"></i>
                    <p>Tidak ada alamat tersimpan.</p>
                    <p>Gunakan tombol berikut untuk menambahkan alamat baru atau kelola alamat yang sudah ada.</p>
                    <div style="margin-top: 20px;">
                        <a class="btn-action" href="/alamat/manage">
                            <i class="fas fa-plus"></i> Kelola Alamat
                        </a>
                    </div>
                </div>
            @else
                @foreach($addresses as $addr)
                    <div class="list-card">
                        <div class="list-header">
                            <h3><i class="fas fa-tag"></i> {{ $addr->label }}</h3>
                            @if($addr->is_default)
                                <span class="badge badge-default">
                                    <i class="fas fa-star"></i> Utama
                                </span>
                            @endif
                        </div>
                        <p><strong>{{ $addr->recipient_name }}</strong> · 📞 {{ $addr->phone }}</p>
                        <p style="color: var(--text-light); margin-top: 8px;">
                            📍 {{ $addr->address_line }}, {{ $addr->city }}, {{ $addr->province }} - {{ $addr->postal_code }}
                        </p>
                        <a class="btn-action btn-outline" href="/alamat/manage" style="margin-top: 16px; display: inline-block;">
                            <i class="fas fa-edit"></i> Kelola Alamat
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    @endif

    <!-- Tab: Riwayat Pesanan -->
    @if($tab == 'orders')
    <div class="section-card">
        <h2><i class="fas fa-history" style="color: var(--gold); margin-right: 10px;"></i> Riwayat Pesanan</h2>
        <div class="orders-list">
            @if($orders->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-shopping-bag"></i>
                    <p>Belum ada pesanan.</p>
                    <p>Silakan mulai berbelanja untuk melihat riwayat pesanan Anda di sini.</p>
                </div>
            @else
                @foreach($orders as $order)
                    <div class="list-card">
                        <div class="list-header">
                            <h3>Order #{{ $order->order_id }}</h3>
                            <span class="badge badge-status">
                                <i class="fas fa-clock"></i> {{ $order->status }}
                            </span>
                        </div>
                        <p style="color: var(--text-light);">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        <div style="display: flex; gap: 12px; flex-wrap: wrap; margin: 16px 0;">
                            <span class="badge" style="background: var(--gold); color: white;">
                                <i class="fas fa-credit-card"></i> Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    @endif

    <!-- Tab: Wishlist -->
    @if($tab == 'wishlist')
    <div class="section-card">
        <h2><i class="fas fa-heart" style="color: var(--gold); margin-right: 10px;"></i> Wishlist</h2>
        <div class="wishlist-list">
            <div class="empty-state">
                <i class="fas fa-heart-broken"></i>
                <p>Wishlist Anda kosong.</p>
                <p>Simpan produk favorit ke wishlist untuk membelinya nanti.</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Tab: Ganti Password -->
    @if($tab == 'password')
    <div class="section-card">
        <h2><i class="fas fa-key" style="color: var(--gold); margin-right: 10px;"></i> Ganti Password</h2>
        <form class="password-form" id="passwordForm" onsubmit="return handleChangePassword(event)">
            <div class="form-group">
                <label>Password Lama</label>
                <input type="password" id="oldPassword" name="oldPassword" required>
            </div>
            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" id="newPassword" name="newPassword" required>
            </div>
            <div class="form-group">
                <label>Konfirmasi Password Baru</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
            </div>
            <button type="submit" class="btn-action">
                <i class="fas fa-save"></i> Simpan Password
            </button>
            <div id="passwordMessage" style="margin-top: 16px;"></div>
        </form>
    </div>
    @endif
</div>

@section('extra_js')
<script src="{{ asset('js/pages/profile.js') }}"></script>
@endsection
