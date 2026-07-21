let allItems = [];
let selectedIds = [];
let deliveryFee = 15000;

function selectAddress(addressId) {
    if (!addressId) {
        document.getElementById('selectedAddressDisplay').style.display = 'none';
        return;
    }
    const address = window.checkoutConfig.userAddresses.find(addr => addr.id == addressId);
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
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        await fetch('/api/cart/clear', { method: 'POST', headers: { 'X-CSRF-TOKEN': token } });
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
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    try {
        const response = await fetch('/api/payments/create', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
            body: JSON.stringify({
                items: selectedItems, addressId,
                customerName: window.checkoutConfig.customerName,
                customerEmail: window.checkoutConfig.customerEmail,
                customerPhone: window.checkoutConfig.customerPhone,
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
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    try {
        const r = await fetch('/api/payments/create', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
            body: JSON.stringify({
                items: selectedItems, addressId,
                customerName: window.checkoutConfig.customerName,
                customerEmail: window.checkoutConfig.customerEmail,
                customerPhone: window.checkoutConfig.customerPhone,
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
    if (window.checkoutConfig) {
        fetchCart();
        const defaultAddr = window.checkoutConfig.userAddresses.find(addr => addr.is_default);
        if (defaultAddr) selectAddress(defaultAddr.id);
    }
});
