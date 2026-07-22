@extends('layouts.app')

@section('title', 'Checkout - FurniNest')

@section('extra_css')
<link rel="stylesheet" href="{{ asset('css/pages/checkout.css') }}">
@endsection

@section('content')
<div class="container py-5 my-5">
    <h1 class="mb-5 d-flex align-items-center gap-3" style="font-family: 'Playfair Display', serif; font-weight: 700; color: var(--brown);">
        <i class="fas fa-shopping-cart" style="color: var(--gold);"></i> Keranjang & Checkout
    </h1>
    
    <div class="row g-5">
        <!-- Left: Cart Items & Selection -->
        <div class="col-lg-7 order-2 order-lg-1">
            <div class="order-summary bg-white p-4 p-md-5 rounded-4 shadow-sm border" style="border-color: var(--border-light) !important;">
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
            </div> <!-- End order-summary -->
        </div> <!-- End col-lg-7 -->

        <!-- Right: Checkout Form -->
        <div class="col-lg-5 order-1 order-lg-2">
            <div class="checkout-form bg-white p-4 p-md-5 rounded-4 shadow-sm border" style="border-color: var(--border-light) !important;">
                <h3 class="mb-4" style="font-family: 'Playfair Display', serif; color: var(--brown); font-weight: 700;">📦 Detail Pengiriman</h3>
            
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
                    @if(count($addresses) == 0)
                        <div class="mt-2">
                            <small class="text-danger mb-2 d-block">⚠️ Anda belum menambahkan alamat pengiriman.</small>
                            <a href="/alamat/manage" class="btn btn-sm w-100 fw-bold" style="background-color: var(--gold); color: white; border-radius: 8px;">
                                <i class="fas fa-plus"></i> Tambah Alamat Sekarang
                            </a>
                        </div>
                    @else
                        <div class="text-end mt-2">
                            <a href="/alamat/manage" class="text-decoration-none small fw-bold" style="color: var(--gold);">
                                <i class="fas fa-map-marker-alt"></i> Kelola / Tambah Alamat
                            </a>
                        </div>
                    @endif
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
                        <img src="/assets/images/logo/doku-logo.svg" alt="DOKU" style="height: 24px;">
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
            </div> <!-- End checkout-form -->
        </div> <!-- End col-lg-5 -->
    </div> <!-- End row -->
</div> <!-- End container -->

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
