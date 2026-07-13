@extends('layouts.app')

@section('title', 'Checkout - FurniNest')

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

<style>
    .checkout-container { max-width: 1200px; margin: 40px auto 80px; padding: 0 24px; }
    .page-title { font-family: 'Playfair Display', serif; font-size: 32px; font-weight: 700; color: var(--brown); margin-bottom: 40px; display: flex; align-items: center; gap: 15px; }
    .page-title i { color: var(--gold); }
    
    .checkout-grid { display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 32px; align-items: start; }
    
    .checkout-form, .order-summary { background: white; border-radius: 24px; padding: 32px; box-shadow: var(--shadow); border: 1px solid var(--border-light); }
    .checkout-form h3, .order-summary h3 { font-family: 'Playfair Display', serif; font-size: 20px; color: var(--brown); margin-bottom: 24px; font-weight: 700; }
    
    .select-all-wrap { display: flex; justify-content: space-between; align-items: center; padding-bottom: 16px; border-bottom: 1px solid var(--border-light); margin-bottom: 8px; }
    .btn-clear-cart { background: transparent; border: none; color: #ff4d4f; font-size: 13px; font-weight: 500; cursor: pointer; transition: 0.3s; }
    .btn-clear-cart:hover { text-decoration: underline; }

    /* Cart Item Styles */
    .cart-item { display: flex; align-items: center; gap: 16px; padding: 20px 0; border-bottom: 1px solid var(--border-light); transition: all 0.3s; }
    .cart-item:last-child { border-bottom: none; }
    .cart-item.unselected { opacity: 0.5; }
    
    .cart-item-img-container { width: 80px; height: 80px; border-radius: 16px; overflow: hidden; background: #f5f5f5; flex-shrink: 0; }
    .cart-item-img { width: 100%; height: 100%; object-fit: cover; border: 1px solid var(--border-light); }
    .cart-item-info { flex: 1; }
    .cart-item-info strong { display: block; font-size: 15px; color: var(--brown); margin-bottom: 4px; }
    .cart-item-info small { color: var(--text-light); font-size: 13px; }
    .cart-item-price { font-weight: 600; color: var(--gold-dark); font-size: 15px; text-align: right; }

    /* Checkbox Styles */
    .checkbox-container { display: flex; align-items: center; position: relative; padding-left: 32px; cursor: pointer; font-size: 14px; user-select: none; }
    .checkbox-container input { position: absolute; opacity: 0; cursor: pointer; height: 0; width: 0; }
    .checkmark { position: absolute; top: 50%; left: 0; transform: translateY(-50%); height: 20px; width: 20px; background-color: #eee; border-radius: 6px; transition: 0.3s; }
    .checkbox-container:hover input ~ .checkmark { background-color: #ddd; }
    .checkbox-container input:checked ~ .checkmark { background-color: var(--gold); }
    .checkmark:after { content: ""; position: absolute; display: none; }
    .checkbox-container input:checked ~ .checkmark:after { display: block; }
    .checkbox-container .checkmark:after { left: 7px; top: 3px; width: 5px; height: 10px; border: solid white; border-width: 0 2px 2px 0; transform: rotate(45deg); }
    .label-text { font-weight: 600; color: var(--brown); }

    /* Totals */
    .totals-section { margin-top: 24px; padding-top: 24px; border-top: 2px dashed var(--border-light); }
    .summary-row { display: flex; justify-content: space-between; padding: 8px 0; color: var(--text-light); font-size: 14px; }
    .summary-row.total { font-size: 20px; font-weight: 800; color: var(--brown); margin-top: 12px; padding-top: 12px; }
    
    /* Form Styles */
    .select-wrapper { position: relative; }
    .select-wrapper i { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: var(--gold); pointer-events: none; }
    .form-group select, .form-group textarea { width: 100%; padding: 14px 16px; background: var(--warm-white); border: 1px solid var(--border-light); border-radius: 16px; color: var(--text-dark); font-family: inherit; font-size: 14px; appearance: none; transition: 0.3s; }
    .form-group select:focus, .form-group textarea:focus { outline: none; border-color: var(--gold); background: white; }
    
    .address-card-selected { background: #fffcf7; border: 1px solid var(--gold); border-radius: 20px; padding: 20px; margin-bottom: 24px; font-size: 14px; line-height: 1.6; color: var(--text-dark); }
    .payment-method-box { display: flex; justify-content: space-between; align-items: center; background: #f9f9f9; padding: 16px 20px; border-radius: 16px; margin-top: 10px; }
    .doku-logo { display: flex; align-items: center; gap: 8px; font-size: 11px; color: #999; }
    
    .btn-pay { width: 100%; padding: 18px; background: var(--brown); border: none; border-radius: 40px; color: white; font-weight: 700; font-size: 16px; cursor: pointer; transition: 0.4s; margin-top: 24px; display: flex; align-items: center; justify-content: center; gap: 12px; box-shadow: 0 8px 25px rgba(92, 61, 46, 0.15); }
    .btn-pay:hover:not(:disabled) { background: var(--dark); transform: translateY(-2px); box-shadow: 0 12px 30px rgba(0,0,0,0.2); }
    .btn-pay:disabled { opacity: 0.6; cursor: not-allowed; }

    .badge-premium { background: linear-gradient(135deg, var(--gold), var(--gold-dark)); color: white; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; }

    @media (max-width: 900px) { .checkout-grid { grid-template-columns: 1fr; } .order-summary { order: 2 !important; } .checkout-form { order: 1 !important; } }
</style>

<script>
    let allItems = [];
    let selectedIds = [];
    const userAddresses = @json($addresses ?? []);
    let deliveryFee = 15000;

    function selectAddress(addressId) {
        if (!addressId) {
            document.getElementById('selectedAddressDisplay').style.display = 'none';
            return;
        }
        const address = userAddresses.find(addr => addr.id == addressId);
        if (address) {
            const detailHtml = `
                <div style="font-weight: 700; color: var(--gold); margin-bottom: 8px; font-size: 16px;">🏠 ${address.label}</div>
                <div style="margin-bottom: 4px;"><i class="fas fa-user" style="width: 20px; color: var(--gold);"></i> ${address.recipient_name}</div>
                <div style="margin-bottom: 4px;"><i class="fas fa-phone" style="width: 20px; color: var(--gold);"></i> ${address.phone}</div>
                <div style="color: var(--text-light);"><i class="fas fa-location-dot" style="width: 20px; color: var(--gold);"></i> ${address.address_line}, ${address.city}, ${address.province} - ${address.postal_code}</div>
            `;
            document.getElementById('selectedAddressDetail').innerHTML = detailHtml;
            document.getElementById('selectedAddressDisplay').style.display = 'block';
        }
    }

    async function fetchCart() {
        try {
            const response = await fetch('/api/cart');
            const data = await response.json();
            if (data.loggedIn && data.items) {
                allItems = data.items;
            } else {
                allItems = JSON.parse(localStorage.getItem('cart') || '[]');
            }
            // By default select all
            selectedIds = allItems.map(item => item.id);
            renderCart();
        } catch (e) {
            allItems = JSON.parse(localStorage.getItem('cart') || '[]');
            selectedIds = allItems.map(item => item.id);
            renderCart();
        }
    }

    function renderCart() {
        const cartContainer = document.getElementById('cartItems');
        if (allItems.length === 0) {
            cartContainer.innerHTML = '<div style="text-align:center;padding:60px;color:var(--text-light);"><i class="fas fa-shopping-basket" style="font-size: 40px; margin-bottom: 15px; opacity: 0.3;"></i><br>Keranjang belanja Anda kosong</div>';
            updateTotals();
            return;
        }

        let html = '';
        allItems.forEach((item) => {
            const isSelected = selectedIds.includes(item.id);
            const price = item.price || 0;
            const quantity = item.quantity || 1;
            const itemTotal = price * quantity;
            
            let imgSrc = item.img || '/images/placeholder.jpg';
            if (imgSrc && !imgSrc.startsWith('http') && !imgSrc.startsWith('/')) {
                imgSrc = '/images/products/' + imgSrc;
            }
            
            html += `
                <div class="cart-item ${isSelected ? '' : 'unselected'}" id="item-${item.id}">
                    <label class="checkbox-container">
                        <input type="checkbox" ${isSelected ? 'checked' : ''} onchange="toggleItem(${item.id}, this.checked)">
                        <span class="checkmark"></span>
                    </label>
                    <div class="cart-item-img-container">
                        <img src="${imgSrc}" class="cart-item-img" alt="${item.name}" onerror="this.src='https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=200&fit=crop'; this.onerror=null;">
                    </div>
                    <div class="cart-item-info">
                        <strong>${item.name}</strong>
                        <small>Rp ${price.toLocaleString('id-ID')} × ${quantity}</small>
                    </div>
                    <div class="cart-item-price">Rp ${itemTotal.toLocaleString('id-ID')}</div>
                </div>
            `;
        });

        cartContainer.innerHTML = html;
        updateTotals();
    }

    function toggleItem(id, checked) {
        if (checked) {
            if (!selectedIds.includes(id)) selectedIds.push(id);
            document.getElementById(`item-${id}`).classList.remove('unselected');
        } else {
            selectedIds = selectedIds.filter(sid => sid !== id);
            document.getElementById(`item-${id}`).classList.add('unselected');
            document.getElementById('selectAllItems').checked = false;
        }
        
        if (selectedIds.length === allItems.length) {
            document.getElementById('selectAllItems').checked = true;
        }
        updateTotals();
    }

    function toggleAll(checked) {
        if (checked) {
            selectedIds = allItems.map(item => item.id);
        } else {
            selectedIds = [];
        }
        renderCart();
    }

    function updateTotals() {
        const orderTotals = document.getElementById('orderTotals');
        let subtotal = 0;
        
        allItems.forEach(item => {
            if (selectedIds.includes(item.id)) {
                subtotal += (item.price || 0) * (item.quantity || 1);
            }
        });

        if (selectedIds.length === 0) {
            orderTotals.innerHTML = `
                <div class="summary-row"><span>Subtotal (0 barang)</span><span>Rp 0</span></div>
                <div class="summary-row total"><span>Total</span><span>Rp 0</span></div>
            `;
            document.getElementById('payButton').disabled = true;
            return;
        }

        document.getElementById('payButton').disabled = false;
        orderTotals.innerHTML = `
            <div class="summary-row"><span>Subtotal (${selectedIds.length} barang)</span><span>Rp ${subtotal.toLocaleString('id-ID')}</span></div>
            <div class="summary-row"><span>Biaya Pengiriman</span><span>Rp ${deliveryFee.toLocaleString('id-ID')}</span></div>
            <div class="summary-row total"><span>Total Pembayaran</span><span>Rp ${(subtotal + deliveryFee).toLocaleString('id-ID')}</span></div>
        `;
    }

    async function clearCart() {
        if (!confirm('Hapus seluruh isi keranjang?')) return;
        try {
            await fetch('/api/cart/clear', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
        } catch (e) {}
        localStorage.removeItem('cart');
        allItems = [];
        selectedIds = [];
        renderCart();
    }

    async function processPayment() {
        const addressId = document.getElementById('addressSelect').value;
        if (!addressId) { showToast('❌ Pilih alamat pengiriman terlebih dahulu!'); return; }
        if (selectedIds.length === 0) { showToast('❌ Pilih minimal satu barang!'); return; }

        const payBtn = document.getElementById('payButton');
        const originalHtml = payBtn.innerHTML;
        payBtn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Memproses...';
        payBtn.disabled = true;

        const selectedItems = allItems.filter(item => selectedIds.includes(item.id));
        try {
            const response = await fetch('/api/payments/create', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({
                    items: selectedItems, addressId,
                    customerName: "{{ session('currentUser')->name ?? 'Guest' }}",
                    customerEmail: "{{ session('currentUser')->email ?? '' }}",
                    customerPhone: "{{ session('currentUser')->phone ?? '' }}",
                    note: document.getElementById('orderNote').value
                })
            });

            const result = await response.json();
            if (result.status === 'SUCCESS' && result.redirectUrl) {
                localStorage.setItem('purchased_ids', JSON.stringify(selectedIds));
                showToast('🚀 Mengalihkan ke DOKU Payment...');
                setTimeout(() => { window.location.href = result.redirectUrl; }, 1500);
            } else if (result.orderId) {
                // Order saved, DOKU redirect unavailable → go to success page
                localStorage.setItem('purchased_ids', JSON.stringify(selectedIds));
                showToast('✅ Pesanan berhasil! Mengarahkan...');
                setTimeout(() => { window.location.href = '/payment-success?orderId=' + result.orderId; }, 1500);
            } else {
                payBtn.innerHTML = originalHtml;
                payBtn.disabled = false;
                showPaymentError(result.message || 'Layanan pembayaran tidak tersedia.', selectedItems, addressId);
            }
        } catch (error) {
            console.error(error);
            payBtn.innerHTML = originalHtml;
            payBtn.disabled = false;
            showToast('❌ Koneksi bermasalah. Silakan coba lagi.');
        }
    }

    function showPaymentError(msg, items, addressId) {
        const existing = document.getElementById('paymentErrorBox');
        if (existing) existing.remove();
        const box = document.createElement('div');
        box.id = 'paymentErrorBox';
        box.style.cssText = 'background:#fff3cd;border:1px solid #ffc107;border-radius:16px;padding:20px;margin-top:16px;font-size:14px;';
        box.innerHTML = `
            <div style="font-weight:700;color:#856404;margin-bottom:8px;">⚠️ Pembayaran online tidak tersedia saat ini</div>
            <div style="color:#666;margin-bottom:14px;font-size:13px;">${msg}</div>
            <button onclick="processCOD()" style="background:#5C3D2E;color:white;border:none;padding:12px 24px;border-radius:30px;font-weight:700;cursor:pointer;width:100%;font-size:15px;">
                📦 Lanjutkan dengan Bayar di Tempat (COD)
            </button>`;
        document.getElementById('payButton').insertAdjacentElement('afterend', box);
    }

    async function processCOD() {
        const addressId = document.getElementById('addressSelect').value;
        const selectedItems = allItems.filter(item => selectedIds.includes(item.id));
        try {
            const r = await fetch('/api/payments/create', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({
                    items: selectedItems, addressId,
                    customerName: "{{ session('currentUser')->name ?? 'Guest' }}",
                    customerEmail: "{{ session('currentUser')->email ?? '' }}",
                    customerPhone: "{{ session('currentUser')->phone ?? '' }}",
                    note: 'COD - ' + (document.getElementById('orderNote').value || '')
                })
            });
            const result = await r.json();
            localStorage.setItem('purchased_ids', JSON.stringify(selectedIds));
            showToast('✅ Pesanan COD berhasil dibuat!');
            setTimeout(() => { window.location.href = '/payment-success?orderId=' + (result.orderId || ''); }, 1500);
        } catch(e) { showToast('❌ Gagal membuat pesanan. Coba lagi.'); }
    }

    function showToast(msg) {
        const toast = document.getElementById('toastMsg');
        if (toast) {
            toast.innerText = msg;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        } else {
            alert(msg);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        fetchCart();
        const defaultAddr = userAddresses.find(addr => addr.is_default);
        if (defaultAddr) selectAddress(defaultAddr.id);
    });
</script>
@endsection
