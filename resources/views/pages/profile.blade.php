@extends('layouts.app')

@section('title', 'Profil Saya - FurniNest')

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

<style>
    .profile-container { max-width: 1100px; margin: 40px auto 60px; padding: 0 20px; }
    .page-header { display: flex; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 32px; flex-wrap: wrap; }
    .page-header h1 { font-family: 'Playfair Display', serif; font-size: 32px; font-weight: 600; color: var(--brown); margin-top: 8px; }
    .welcome-badge { display: inline-block; font-size: 12px; letter-spacing: 3px; color: var(--gold); font-weight: 600; text-transform: uppercase; margin-bottom: 8px; }
    .profile-tabs { display: flex; flex-wrap: wrap; gap: 8px; background: white; padding: 8px; border-radius: 20px; margin-bottom: 32px; box-shadow: var(--shadow); border: 1px solid var(--border-light); }
    .profile-tab { padding: 12px 24px; border-radius: 16px; color: var(--text-light); text-decoration: none; font-weight: 600; font-size: 14px; transition: all 0.3s ease; }
    .profile-tab i { margin-right: 8px; }
    .profile-tab.active, .profile-tab:hover { color: white; background: var(--gold); }
    .section-card { background: white; border-radius: 28px; padding: 32px; box-shadow: var(--shadow); border: 1px solid var(--border-light); }
    .section-card h2 { font-family: 'Playfair Display', serif; font-size: 24px; font-weight: 600; color: var(--brown); margin-bottom: 24px; }
    .profile-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 32px; }
    .profile-info-item { margin-bottom: 20px; }
    .profile-info-item label { display: block; font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: var(--brown); margin-bottom: 8px; }
    .profile-info-item input { width: 100%; padding: 14px 16px; border-radius: 16px; border: 1px solid var(--border-light); background: var(--warm-white); font-family: 'Inter', sans-serif; font-size: 14px; }
    .btn-action { display: inline-flex; align-items: center; gap: 8px; padding: 12px 28px; border-radius: 40px; background: var(--brown); color: white; text-decoration: none; font-weight: 600; font-size: 14px; border: none; cursor: pointer; }
    .btn-action:hover { background: var(--gold); transform: translateY(-2px); }
    .btn-outline { background: transparent; border: 1.5px solid var(--gold); color: var(--gold-dark); }
    .btn-outline:hover { background: var(--gold); color: white; }
    .list-card { background: var(--warm-white); border: 1px solid var(--border-light); border-radius: 20px; padding: 20px; margin-bottom: 15px; }
    .list-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
    .badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 30px; font-size: 11px; font-weight: 600; }
    .badge-default { background: var(--gold); color: white; }
    .badge-status { background: rgba(198, 161, 91, 0.15); color: var(--gold-dark); }
    .empty-state { text-align: center; padding: 48px 24px; background: var(--warm-white); border-radius: 20px; border: 1px dashed var(--border-light); color: var(--text-light); }
    .empty-state i { font-size: 48px; color: var(--gold); margin-bottom: 16px; display: block; }
    @media (max-width: 900px) { .profile-grid { grid-template-columns: 1fr; } .profile-tabs { overflow-x: auto; flex-wrap: nowrap; } .profile-tab { white-space: nowrap; } }
</style>

<script>
    async function saveAccountInfo(e) {
        e.preventDefault();
        const msgDiv = document.getElementById('profileMessage');
        msgDiv.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Menyimpan...';
        
        try {
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData.entries());
            const response = await fetch('/api/profile/update', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify(data)
            });
            const result = await response.json();
            if (result.status === 'SUCCESS') {
                msgDiv.innerHTML = '<div class="message-success"><i class="fas fa-check-circle"></i> Profil berhasil diperbarui!</div>';
                showToast('✓ Profil diperbarui');
            } else {
                msgDiv.innerHTML = '<div class="message-error"><i class="fas fa-times-circle"></i> ' + result.message + '</div>';
            }
        } catch (err) {
            msgDiv.innerHTML = '<div class="message-error">Terjadi kesalahan sistem</div>';
        }
    }

    async function handleChangePassword(e) {
        e.preventDefault();
        const msgDiv = document.getElementById('passwordMessage');
        const pass = document.getElementById('newPassword').value;
        const confirm = document.getElementById('confirmPassword').value;
        
        if (pass !== confirm) {
            msgDiv.innerHTML = '<div class="message-error">Konfirmasi password tidak cocok</div>';
            return;
        }

        msgDiv.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Mengubah password...';
        try {
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData.entries());
            const response = await fetch('/api/profile/password', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify(data)
            });
            const result = await response.json();
            if (result.status === 'SUCCESS') {
                msgDiv.innerHTML = '<div class="message-success"><i class="fas fa-check-circle"></i> Password berhasil diubah!</div>';
                e.target.reset();
                showToast('✓ Password diubah');
            } else {
                msgDiv.innerHTML = '<div class="message-error">' + result.message + '</div>';
            }
        } catch (err) {
            msgDiv.innerHTML = '<div class="message-error">Terjadi kesalahan sistem</div>';
        }
    }
</script>
@endsection
