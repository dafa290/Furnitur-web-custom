@extends('layouts.app')

@section('title', 'Checkout - FurniNest')

@section('extra_css')
<link rel="stylesheet" href="{{ asset('css/pages/checkout.css') }}">
@endsection

@section('content')
<div class="checkout-container">
    <h1 class="page-title"><i class="fas fa-shopping-cart"></i> Keranjang & Checkout</h1>
    
    <div class="checkout-grid">
        <!-- Left: Cart Items & Selection -->
        <div class="order-summary" style="order: 1;">
            <div class="summary-header" style="margin-bottom: 30px;">
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <h3>🛍️ Barang yang dibeli</h3>
                    <span class="badge-premium" style="width: fit-content;">Premium Quality</span>
                </div>
            </div>
            
            <div class="select-all-wrap">
                <label class="checkbox-container">
                    <input type="checkbox" id="selectAllItems" checked onchange="toggleAll(this.checked)">
                    <span class="checkmark"></span>
                    <span class="label-text">Pilih Semua</span>
                </label>
                <button class="btn-clear-cart" onclick="clearCart()">Hapus Semua</button>
            </div>

            <div id="cartItems"></div>
            
            <div id="orderTotals" class="totals-section"></div>
            
            <div class="checkout-note">
                <i class="fas fa-truck"></i> Estimasi tiba dalam 2–4 hari kerja setelah pesanan dikonfirmasi
            </div>
        </div>

        <!-- Right: Checkout Form -->
        <div class="checkout-form" style="order: 2;">
            <h3>📦 Detail Pengiriman</h3>
            
            @if(session('currentUser'))
                <div class="form-group">
                    <label>Pilih Alamat Tersimpan</label>
                    <div class="select-wrapper">
                        <select id="addressSelect" onchange="selectAddress(this.value)">
                            <option value="">-- Pilih alamat --</option>
                            @foreach($addresses as $addr)
                                <option value="{{ $addr->id }}" {{ $addr->is_default ? 'selected' : '' }}>
                                    {{ $addr->label }} - {{ $addr->recipient_name }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
                
                <div id="selectedAddressDisplay" style="display: none;" class="address-card-selected">
                    <div id="selectedAddressDetail"></div>
                </div>
                
                <div class="form-group">
                    <label>Catatan Pesanan (Opsional)</label>
                    <textarea id="orderNote" rows="3" placeholder="Contoh: Tolong hubungi sebelum dikirim atau titipkan ke satpam."></textarea>
                </div>

                <div class="payment-method-box">
                    <div class="label-text">Metode Pembayaran</div>
                    <div class="doku-logo">
                        <span>Powered by</span>
                        <img src="https://doku.id/assets/img/logo-doku.png" alt="DOKU" style="height: 24px;" onerror="this.src='https://cdn.worldvectorlogo.com/logos/doku.svg'; this.onerror=null;">
                    </div>
                </div>

                <button class="btn-pay" id="payButton" onclick="processPayment()">
                    <i class="fas fa-shield-alt"></i> Bayar Sekarang
                </button>
            @else
                <div class="login-warning">
                    <p>⚠️ Silakan login terlebih dahulu untuk melanjutkan checkout</p>
                </div>
                <a href="/login" class="btn-pay" style="display:block; text-align:center; text-decoration:none;">
                    <i class="fas fa-sign-in-alt"></i> Login Sekarang
                </a>
            @endif
        </div>
    </div>
</div>

@section('extra_js')
<script>
    window.checkoutConfig = {
        userAddresses: @json($addresses ?? []),
        customerName: "{{ session('currentUser')->name ?? 'Guest' }}",
        customerEmail: "{{ session('currentUser')->email ?? '' }}",
        customerPhone: "{{ session('currentUser')->phone ?? '' }}"
    };
</script>
<script src="{{ asset('js/pages/checkout.js') }}"></script>
@endsection
@endsection
