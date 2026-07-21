function incrementQty(maxStock) {
    const input = document.getElementById('quantity');
    let val = parseInt(input.value);
    if (val < maxStock) input.value = val + 1;
    else {
        if (typeof showToast === 'function') showToast('Stok tidak mencukupi');
    }
}
function decrementQty() {
    const input = document.getElementById('quantity');
    let val = parseInt(input.value);
    if (val > 1) input.value = val - 1;
}
function addToCartDetailPage(productId) {
    const qty = parseInt(document.getElementById('quantity').value);
    if (productId === 0) return;
    
    if (typeof window.addToCart === 'function') {
        window.addToCart(productId, qty);
    }
}
