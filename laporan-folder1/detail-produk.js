// ===== CART STATE =====
let cartCount = 0;

// ===== QUANTITY CONTROLS =====
function incrementQty() {
    const input = document.getElementById('quantity');
    let val = parseInt(input.value);
    const max = parseInt(input.getAttribute('max'));
    if (val < max) {
        input.value = val + 1;
    }
}

function decrementQty() {
    const input = document.getElementById('quantity');
    let val = parseInt(input.value);
    if (val > 1) {
        input.value = val - 1;
    }
}

// ===== ADD TO CART =====
function addToCart() {
    const qty = parseInt(document.getElementById('quantity').value);
    cartCount += qty;

    // Update cart badge
    document.getElementById('cartBadge').textContent = cartCount;

    // Show toast notification
    const toast = document.getElementById('toastMsg');
    toast.textContent = `\u2714 ${qty} item ditambahkan ke keranjang!`;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 2500);
}
