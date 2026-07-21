@extends('layouts.app')

@section('title', 'Profil Saya - FurniNest')

@section('extra_css')
<!-- Styles now handled by Bootstrap -->
@endsection

@section('content')
<div class="container py-5 my-5">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill fw-bold text-uppercase mb-2"><i class="fas fa-user me-1"></i> Akun Saya</span>
            <h1 class="h2 fw-bold" style="font-family: 'Playfair Display', serif; color: var(--brown);">Selamat datang, {{ $user->name }}</h1>
        </div>
        <button class="btn btn-outline-danger fw-bold rounded-pill px-4" onclick="window.location.href='/logout'">
            <i class="fas fa-sign-out-alt me-2"></i> Keluar
        </button>
    </div>

    <!-- Tabs -->
    <div class="d-flex flex-wrap gap-2 bg-white p-2 rounded-4 shadow-sm border mb-4">
        <a class="btn rounded-pill px-4 fw-bold {{ $tab == 'profile' ? 'btn-warning text-white' : 'btn-light text-muted' }}" href="/profile?tab=profile">
            <i class="fas fa-user me-2"></i> Informasi Akun
        </a>
        <a class="btn rounded-pill px-4 fw-bold {{ $tab == 'address' ? 'btn-warning text-white' : 'btn-light text-muted' }}" href="/profile?tab=address">
            <i class="fas fa-map-marker-alt me-2"></i> Alamat Saya
        </a>
        <a class="btn rounded-pill px-4 fw-bold {{ $tab == 'orders' ? 'btn-warning text-white' : 'btn-light text-muted' }}" href="/profile?tab=orders">
            <i class="fas fa-box me-2"></i> Riwayat Pesanan
        </a>
        <a class="btn rounded-pill px-4 fw-bold {{ $tab == 'wishlist' ? 'btn-warning text-white' : 'btn-light text-muted' }}" href="/profile?tab=wishlist">
            <i class="fas fa-heart me-2"></i> Wishlist
        </a>
        <a class="btn rounded-pill px-4 fw-bold {{ $tab == 'password' ? 'btn-warning text-white' : 'btn-light text-muted' }}" href="/profile?tab=password">
            <i class="fas fa-lock me-2"></i> Ganti Password
        </a>
    </div>

    <!-- Tab: Informasi Akun -->
    @if($tab == 'profile')
    <div class="card shadow-sm border-0 rounded-4 p-4 p-md-5 bg-white">
        <h2 class="h4 fw-bold mb-4" style="font-family: 'Playfair Display', serif; color: var(--brown);"><i class="fas fa-user-edit text-warning me-2"></i> Informasi Akun</h2>
        <form id="accountForm" onsubmit="return saveAccountInfo(event)">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold text-uppercase">Nama Lengkap</label>
                        <input type="text" id="name" name="name" class="form-control form-control-lg bg-light" value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold text-uppercase">Email</label>
                        <input type="email" id="email" name="email" class="form-control form-control-lg bg-light" value="{{ $user->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold text-uppercase">Nomor Telepon</label>
                        <input type="tel" id="phone" name="phone" class="form-control form-control-lg bg-light" value="{{ $user->phone }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-start gap-3 bg-light p-4 rounded-4 mb-4">
                        <i class="fas fa-info-circle text-warning mt-1"></i>
                        <p class="mb-0 small text-muted">Halo! Di halaman ini Anda dapat memperbarui data akun secara instan. Simpan setiap perubahan untuk memastikan profil Anda tetap akurat dan siap digunakan untuk pesanan selanjutnya.</p>
                    </div>
                    <button type="submit" class="btn w-100 py-3 fw-bold rounded-pill text-white" style="background-color: var(--brown);">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
            <div id="profileMessage" class="mt-3"></div>
        </form>
    </div>
    @endif

    <!-- Tab: Alamat Saya -->
    @if($tab == 'address')
    <div class="card shadow-sm border-0 rounded-4 p-4 p-md-5 bg-white">
        <h2 class="h4 fw-bold mb-4" style="font-family: 'Playfair Display', serif; color: var(--brown);"><i class="fas fa-map-pin text-warning me-2"></i> Alamat Saya</h2>
        <div>
            @if($addresses->isEmpty())
                <div class="text-center py-5 bg-light rounded-4 border border-dashed">
                    <i class="fas fa-map-marker-alt text-warning fa-3x mb-3"></i>
                    <p class="text-muted mb-1">Tidak ada alamat tersimpan.</p>
                    <p class="text-muted small mb-4">Gunakan tombol berikut untuk menambahkan alamat baru atau kelola alamat yang sudah ada.</p>
                    <a class="btn fw-bold rounded-pill text-white px-4 py-2" style="background-color: var(--brown);" href="/alamat/manage">
                        <i class="fas fa-plus me-2"></i> Kelola Alamat
                    </a>
                </div>
            @else
                <div class="row g-4">
                @foreach($addresses as $addr)
                    <div class="col-12">
                        <div class="card bg-light border-0 rounded-4 p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h3 class="h6 fw-bold mb-0"><i class="fas fa-tag me-2"></i> {{ $addr->label }}</h3>
                                @if($addr->is_default)
                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-1">
                                        <i class="fas fa-star me-1"></i> Utama
                                    </span>
                                @endif
                            </div>
                            <p class="mb-2"><strong>{{ $addr->recipient_name }}</strong> · 📞 {{ $addr->phone }}</p>
                            <p class="text-muted small mb-3">
                                📍 {{ $addr->address_line }}, {{ $addr->city }}, {{ $addr->province }} - {{ $addr->postal_code }}
                            </p>
                            <a class="btn btn-outline-dark btn-sm rounded-pill px-3 fw-bold" href="/alamat/manage">
                                <i class="fas fa-edit me-1"></i> Kelola Alamat
                            </a>
                        </div>
                    </div>
                @endforeach
                </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Tab: Riwayat Pesanan -->
    @if($tab == 'orders')
    <div class="card shadow-sm border-0 rounded-4 p-4 p-md-5 bg-white">
        <h2 class="h4 fw-bold mb-4" style="font-family: 'Playfair Display', serif; color: var(--brown);"><i class="fas fa-history text-warning me-2"></i> Riwayat Pesanan</h2>
        <div>
            @if($orders->isEmpty())
                <div class="text-center py-5 bg-light rounded-4 border border-dashed">
                    <i class="fas fa-shopping-bag text-warning fa-3x mb-3"></i>
                    <p class="text-muted mb-1">Belum ada pesanan.</p>
                    <p class="text-muted small">Silakan mulai berbelanja untuk melihat riwayat pesanan Anda di sini.</p>
                </div>
            @else
                <div class="row g-4">
                @foreach($orders as $order)
                    <div class="col-12">
                        <div class="card bg-light border-0 rounded-4 p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h3 class="h6 fw-bold mb-0">Order #{{ $order->order_id }}</h3>
                                <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill">
                                    <i class="fas fa-clock me-1"></i> {{ $order->status }}
                                </span>
                            </div>
                            <p class="text-muted small mb-3">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            <div class="d-inline-block badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold">
                                <i class="fas fa-credit-card me-1"></i> Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Tab: Wishlist -->
    @if($tab == 'wishlist')
    <div class="card shadow-sm border-0 rounded-4 p-4 p-md-5 bg-white">
        <h2 class="h4 fw-bold mb-4" style="font-family: 'Playfair Display', serif; color: var(--brown);"><i class="fas fa-heart text-warning me-2"></i> Wishlist</h2>
        <div>
            @if(isset($wishlists) && $wishlists->isEmpty())
                <div class="text-center py-5 bg-light rounded-4 border border-dashed">
                    <i class="fas fa-heart-broken text-warning fa-3x mb-3"></i>
                    <p class="text-muted mb-1">Wishlist Anda kosong.</p>
                    <p class="text-muted small">Simpan produk favorit ke wishlist untuk membelinya nanti.</p>
                </div>
            @else
                <div class="row g-4">
                    @foreach($wishlists as $item)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-0 rounded-4 shadow-sm">
                                <img src="{{ $item->product_img }}" class="card-img-top rounded-top-4" alt="{{ $item->product_name }}" style="height: 200px; object-fit: cover;">
                                <div class="card-body p-4 d-flex flex-column">
                                    <h3 class="h6 fw-bold mb-2">{{ $item->product_name }}</h3>
                                    <p class="text-warning fw-bold mb-3">Rp {{ number_format($item->product_price, 0, ',', '.') }}</p>
                                    <div class="mt-auto d-flex gap-2">
                                        <a href="/product/{{ $item->product_id }}" class="btn btn-outline-dark btn-sm rounded-pill flex-grow-1 fw-bold text-center py-2">Lihat Produk</a>
                                        <button class="btn btn-outline-danger btn-sm rounded-pill fw-bold" onclick="removeFromWishlist('{{ $item->product_id }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Tab: Ganti Password -->
    @if($tab == 'password')
    <div class="card shadow-sm border-0 rounded-4 p-4 p-md-5 bg-white">
        <h2 class="h4 fw-bold mb-4" style="font-family: 'Playfair Display', serif; color: var(--brown);"><i class="fas fa-key text-warning me-2"></i> Ganti Password</h2>
        <form class="password-form" id="passwordForm" onsubmit="return handleChangePassword(event)">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold text-uppercase">Password Lama</label>
                        <input type="password" id="oldPassword" name="oldPassword" class="form-control form-control-lg bg-light" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold text-uppercase">Password Baru</label>
                        <input type="password" id="newPassword" name="newPassword" class="form-control form-control-lg bg-light" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted small fw-bold text-uppercase">Konfirmasi Password Baru</label>
                        <input type="password" id="confirmPassword" name="confirmPassword" class="form-control form-control-lg bg-light" required>
                    </div>
                    <button type="submit" class="btn w-100 py-3 fw-bold rounded-pill text-white" style="background-color: var(--brown);">
                        <i class="fas fa-save me-2"></i> Simpan Password
                    </button>
                    <div id="passwordMessage" class="mt-3"></div>
                </div>
            </div>
        </form>
    </div>
    @endif
</div>

@section('extra_js')
<script src="{{ asset('js/pages/profile.js') }}"></script>
@endsection
