/**
 * ============================================================
 * 📁 STRUKTUR FOLDER GAMBAR
 * ============================================================
 * 
 * assets/
 * ├── images/
 * │   ├── logo/
 * │   │   └── logo.jpg
 * │   ├── hero/
 * │   │   ├── bg-hero.jpg
 * │   │   ├── hero-1.jpg
 * │   │   ├── hero-2.jpg
 * │   │   └── hero-3.jpg
 * │   ├── promo/
 * │   │   └── promo.jpg
 * │   └── products/
 * │       ├── produk-1.jpg  s/d produk-15.jpg
 * 
 * ============================================================
 */

// Debug: confirm script load and global errors
console.log('script.js loaded');
window.addEventListener('error', (e) => {
    console.error('Global error caught:', e.message, 'at', e.filename + ':' + e.lineno);
});

// ========== DATA PRODUK (15 PRODUK) ==========
const products = [
    { 
        id: 1, 
        name: "Sofa Minimalis L-Shape", 
        category: "Sofa", 
        price: 3500000, 
        oldPrice: 4500000, 
        rating: 4.8, 
        sold: 234, 
        desc: "Sofa modern dengan busa berkualitas tinggi, nyaman untuk bersantai. Desain ergonomis dan material premium.",
        image: "assets/images/products/produk-1.jpg",
        colors: ["Coklat", "Abu-abu", "Hitam"], 
        sizes: ["2 Seater", "3 Seater", "L-Shape"] 
    },
    { 
        id: 2, 
        name: "Meja Makan Kayu Jati", 
        category: "Meja", 
        price: 2800000, 
        oldPrice: 3200000, 
        rating: 4.6, 
        sold: 156, 
        desc: "Meja makan dari kayu jati solid, finishing natural anti gores. Cocok untuk 4-6 orang.",
        image: "assets/images/products/produk-2.jpg",
        colors: ["Natural", "Walnut"], 
        sizes: ["140cm", "160cm", "180cm"] 
    },
    { 
        id: 3, 
        name: "Kursi Santai Modern", 
        category: "Kursi", 
        price: 850000, 
        oldPrice: 1200000, 
        rating: 4.7, 
        sold: 432, 
        desc: "Kursi santai dengan desain ergonomis, bantalan empuk, dan rangka kokoh.",
        image: "assets/images/products/produk-3.jpg",
        colors: ["Biru", "Abu-abu", "Merah"], 
        sizes: ["Standard"] 
    },
    { 
        id: 4, 
        name: "Lemari Pakaian 2 Pintu", 
        category: "Lemari", 
        price: 2900000, 
        oldPrice: 3500000, 
        rating: 4.5, 
        sold: 89, 
        desc: "Lemari dengan desain minimalis, ruang penyimpanan luas, dan kualitas premium.",
        image: "assets/images/products/produk-4.jpg",
        colors: ["Putih", "Coklat"], 
        sizes: ["2 Pintu", "3 Pintu"] 
    },
    { 
        id: 5, 
        name: "Tempat Tidur Queen Size", 
        category: "Tempat Tidur", 
        price: 4200000, 
        oldPrice: 5000000, 
        rating: 4.9, 
        sold: 167, 
        desc: "Tempat tidur dengan headboard empuk, rangka kuat, dan desain elegan.",
        image: "assets/images/products/produk-5.jpg",
        colors: ["Coklat", "Abu-abu"], 
        sizes: ["Queen", "King"] 
    },
    { 
        id: 6, 
        name: "Meja Kerja Ergonomis", 
        category: "Meja", 
        price: 1800000, 
        oldPrice: 2200000, 
        rating: 4.6, 
        sold: 278, 
        desc: "Meja kerja dengan desain modern, tinggi adjustable, dan material berkualitas.",
        image: "assets/images/products/produk-6.jpg",
        colors: ["Putih", "Hitam"], 
        sizes: ["120cm", "140cm"] 
    },
    { 
        id: 7, 
        name: "Kursi Putar Kantor", 
        category: "Kursi", 
        price: 950000, 
        oldPrice: 1300000, 
        rating: 4.4, 
        sold: 543, 
        desc: "Kursi kantor dengan sandaran tinggi, roda halus, dan bantalan empuk.",
        image: "assets/images/products/produk-7.jpg",
        colors: ["Hitam", "Abu-abu"], 
        sizes: ["Standard"] 
    },
    { 
        id: 8, 
        name: "Rak Buku Minimalis", 
        category: "Lemari", 
        price: 1250000, 
        oldPrice: 1600000, 
        rating: 4.5, 
        sold: 198, 
        desc: "Rak buku dengan desain minimalis, cocok untuk ruang tamu atau kantor.",
        image: "assets/images/products/produk-8.jpg",
        colors: ["Putih", "Coklat"], 
        sizes: ["3 Susun", "5 Susun"] 
    },
    { 
        id: 9, 
        name: "Sofa Bed 2in1", 
        category: "Sofa", 
        price: 3200000, 
        oldPrice: 4000000, 
        rating: 4.7, 
        sold: 312, 
        desc: "Sofa yang dapat diubah menjadi tempat tidur. Solusi cerdas untuk ruang terbatas.",
        image: "assets/images/products/produk-9.jpg",
        colors: ["Abu-abu", "Biru"], 
        sizes: ["Standard"] 
    },
    { 
        id: 10, 
        name: "Coffee Table Marble", 
        category: "Meja", 
        price: 1500000, 
        oldPrice: 2100000, 
        rating: 4.8, 
        sold: 145, 
        desc: "Meja kopi dengan permukaan marmer natural dan kaki kayu solid.",
        image: "assets/images/products/produk-10.jpg",
        colors: ["Putih Marmer", "Hitam Marmer"], 
        sizes: ["80cm", "100cm"] 
    },
    { 
        id: 11, 
        name: "TV Cabinet Modern", 
        category: "Lemari", 
        price: 2100000, 
        oldPrice: 2800000, 
        rating: 4.6, 
        sold: 98, 
        desc: "Kabinet TV minimalis dengan ruang penyimpanan luas.",
        image: "assets/images/products/produk-11.jpg",
        colors: ["Coklat", "Putih"], 
        sizes: ["150cm", "180cm", "200cm"] 
    },
    { 
        id: 12, 
        name: "Nightstand Set", 
        category: "Lemari", 
        price: 750000, 
        oldPrice: 1100000, 
        rating: 4.7, 
        sold: 267, 
        desc: "Set meja samping tempat tidur dengan 2 laci.",
        image: "assets/images/products/produk-12.jpg",
        colors: ["Coklat", "Putih"], 
        sizes: ["Standard"] 
    },
    { 
        id: 13, 
        name: "Dining Chair Set 6", 
        category: "Kursi", 
        price: 2450000, 
        oldPrice: 3200000, 
        rating: 4.7, 
        sold: 189, 
        desc: "Set 6 kursi makan dengan desain skandinavia yang elegan.",
        image: "assets/images/products/produk-13.jpg",
        colors: ["Hitam", "Abu-abu", "Coklat"], 
        sizes: ["Set 4 kursi", "Set 6 kursi"] 
    },
    { 
        id: 14, 
        name: "King Size Bed Frame", 
        category: "Tempat Tidur", 
        price: 5800000, 
        oldPrice: 7200000, 
        rating: 4.9, 
        sold: 76, 
        desc: "Ranjang king size dengan headboard berlapis kulit premium.",
        image: "assets/images/products/produk-14.jpg",
        colors: ["Coklat", "Hitam"], 
        sizes: ["Queen", "King"] 
    },
    { 
        id: 15, 
        name: "Accent Chair Velvet", 
        category: "Kursi", 
        price: 1250000, 
        oldPrice: 1800000, 
        rating: 4.8, 
        sold: 234, 
        desc: "Kursi aksen berbahan velvet dengan desain mewah dan nyaman.",
        image: "assets/images/products/produk-15.jpg",
        colors: ["Biru Navy", "Merah Maroon", "Abu-abu"], 
        sizes: ["Standard"] 
    }
];

// ========== VARIABLES ==========
let cart = [];
let currentFilter = "all";
let currentSort = "default";
let minPriceFilter = 0;
let maxPriceFilter = 10000000;
let currentProduct = null;
let selectedColor = null;
let selectedSize = null;
let quantity = 1;
let selectedShipping = "standard";
let selectedPayment = "bca";
let searchTimeout = null;

const shippingCost = { standard: 20000, express: 50000 };
const shippingNames = { standard: "Standard (3-5 days)", express: "Express (1-2 days)" };
const paymentNames = { bca: "Credit Card", mandiri: "Bank Transfer", other: "E-Wallet" };

// ========== UTILITY FUNCTIONS ==========
function showToast(message, isError = false) {
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toastMessage');
    const icon = toast.querySelector('i');
    
    toastMessage.textContent = message;
    if (isError) {
        icon.style.color = '#E07C6C';
        icon.className = 'fas fa-exclamation-circle';
    } else {
        icon.style.color = '#4CAF50';
        icon.className = 'fas fa-check-circle';
    }
    
    toast.classList.add('show');
    setTimeout(() => {
        toast.classList.remove('show');
    }, 2500);
}

// ========== RENDER CATEGORIES ==========
function renderCategories() {
    const categories = ["Sofa", "Meja", "Kursi", "Lemari", "Tempat Tidur"];
    const grid = document.getElementById('categoryGrid');
    if(grid) {
        grid.innerHTML = categories.map(cat => `
            <div class="category-item" onclick="filterByCategory('${cat}')">
                <div class="category-icon"><i class="fas fa-${cat === 'Sofa' ? 'couch' : cat === 'Meja' ? 'table' : cat === 'Kursi' ? 'chair' : cat === 'Lemari' ? 'archive' : 'bed'}"></i></div>
                <h3>${cat}</h3>
            </div>
        `).join('');
    }
}

// ========== RENDER PRODUCTS ==========
function renderProducts(containerId, productList, limit = null) {
    const container = document.getElementById(containerId);
    if(!container) return;
    let items = limit ? productList.slice(0, limit) : productList;
    if(items.length === 0) {
        container.innerHTML = '<div style="text-align:center; padding:3rem; color:var(--text-muted);"><i class="fas fa-box-open" style="font-size:3rem; margin-bottom:1rem; display:block;"></i>No products found</div>';
        return;
    }
    container.innerHTML = items.map(p => `
        <div class="product-card" onclick="openProductDetail(${p.id})">
            <img class="product-img" src="${p.image}" alt="${p.name}" loading="lazy" onerror="this.src='https://placehold.co/400x300?text=No+Image'">
            <div class="product-info">
                <div class="product-title">${p.name}</div>
                <div class="product-category">${p.category}</div>
                <div class="product-price">Rp ${p.price.toLocaleString()}</div>
                <button class="add-cart-btn" onclick="event.stopPropagation(); addToCartQuick(${p.id})"><i class="fas fa-shopping-bag"></i> Add to Cart</button>
            </div>
        </div>
    `).join('');
}

// ========== FILTER & SORT ==========
function filterAndSortProducts() {
    let filtered = products.filter(p => {
        if(currentFilter !== "all" && p.category !== currentFilter) return false;
        if(p.price < minPriceFilter || p.price > maxPriceFilter) return false;
        return true;
    });
    if(currentSort === "priceLow") filtered.sort((a,b) => a.price - b.price);
    else if(currentSort === "priceHigh") filtered.sort((a,b) => b.price - a.price);
    else if(currentSort === "popular") filtered.sort((a,b) => b.sold - a.sold);
    renderProducts('allProductsGrid', filtered);
}

window.filterByCategory = (cat) => {
    currentFilter = cat;
    filterAndSortProducts();
    showPage('products');
    
    document.querySelectorAll('.filter-btn[data-filter]').forEach(btn => {
        if(btn.getAttribute('data-filter') === cat) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });
};

// ========== SEARCH FUNCTION ==========
function setupSearch() {
    const searchIcon = document.getElementById('searchIcon');
    const searchModal = document.getElementById('searchModal');
    const closeSearch = document.getElementById('closeSearch');
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
    
    if(searchIcon) {
        searchIcon.addEventListener('click', () => {
            searchModal.style.display = 'flex';
            searchInput.focus();
        });
    }
    
    if(closeSearch) {
        closeSearch.addEventListener('click', () => {
            searchModal.style.display = 'none';
            searchResults.innerHTML = '';
            searchInput.value = '';
        });
    }
    
    if(searchModal) {
        searchModal.addEventListener('click', (e) => {
            if(e.target === searchModal) {
                searchModal.style.display = 'none';
                searchResults.innerHTML = '';
                searchInput.value = '';
            }
        });
    }
    
    if(searchInput) {
        searchInput.addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const query = e.target.value.toLowerCase();
                if(query.length < 2) {
                    searchResults.innerHTML = '<div style="text-align:center; padding:2rem; color:var(--text-muted);">Type at least 2 characters</div>';
                    return;
                }
                const filtered = products.filter(p => 
                    p.name.toLowerCase().includes(query) || 
                    p.category.toLowerCase().includes(query)
                );
                if(filtered.length === 0) {
                    searchResults.innerHTML = '<div style="text-align:center; padding:2rem; color:var(--text-muted);">No products found</div>';
                } else {
                    searchResults.innerHTML = filtered.map(p => `
                        <div class="search-result-item" onclick="selectSearchResult(${p.id})">
                            <img src="${p.image}" alt="${p.name}" onerror="this.src='https://placehold.co/60x60?text=No+Image'">
                            <div>
                                <div style="font-weight:600;">${p.name}</div>
                                <div style="color:var(--gold);">Rp ${p.price.toLocaleString()}</div>
                            </div>
                        </div>
                    `).join('');
                }
            }, 300);
        });
    }
}

window.selectSearchResult = (id) => {
    document.getElementById('searchModal').style.display = 'none';
    document.getElementById('searchInput').value = '';
    openProductDetail(id);
};

// ========== NEWSLETTER FUNCTION ==========
function setupNewsletter() {
    const subscribeBtn = document.getElementById('subscribeBtn');
    const newsletterEmail = document.getElementById('newsletterEmail');
    
    if(subscribeBtn) {
        subscribeBtn.addEventListener('click', () => {
            const email = newsletterEmail.value.trim();
            if(email && email.includes('@') && email.includes('.')) {
                showToast(`Thanks for subscribing! We'll send updates to ${email}`);
                newsletterEmail.value = '';
            } else {
                showToast('Please enter a valid email address!', true);
            }
        });
    }
}

// ========== CART FUNCTIONS ==========
function addToCart(id, qty, color, size) {
    const existing = cart.find(item => item.id === id && item.selectedColor === color && item.selectedSize === size);
    const product = products.find(p => p.id === id);
    
    if(existing) {
        existing.quantity += qty;
        showToast(`${product.name} quantity updated!`);
    } else {
        cart.push({ ...product, quantity: qty, selectedColor: color, selectedSize: size });
        showToast(`${product.name} added to cart!`);
    }
    updateCartUI();
}

window.addToCartQuick = (id) => {
    const product = products.find(p => p.id === id);
    addToCart(id, 1, product.colors[0], product.sizes[0]);
};

function updateCartUI() {
    const cartCount = document.getElementById('cartCount');
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    if(cartCount) cartCount.innerText = totalItems;
    
    const cartItemsDiv = document.getElementById('cartItemsList');
    if(cartItemsDiv) {
        if(cart.length === 0) {
            cartItemsDiv.innerHTML = '<div style="text-align:center; padding:2rem; color:var(--text-muted);"><i class="fas fa-shopping-bag" style="font-size:3rem; margin-bottom:1rem; display:block;"></i>Your cart is empty</div>';
        } else {
            cartItemsDiv.innerHTML = cart.map((item, idx) => `
                <div class="cart-item">
                    <img class="cart-item-img" src="${item.image}" alt="${item.name}" onerror="this.src='https://placehold.co/70x70?text=No+Image'">
                    <div class="cart-item-info">
                        <div class="cart-item-title">${item.name}</div>
                        <div class="cart-item-price">Rp ${item.price.toLocaleString()}</div>
                        <div style="font-size:0.75rem; color:var(--text-muted);">${item.selectedColor} | ${item.selectedSize}</div>
                        <div style="font-size:0.85rem;">Qty: ${item.quantity}</div>
                        <div class="remove-item" onclick="removeCartItem(${idx})"><i class="fas fa-trash-alt"></i> Remove</div>
                    </div>
                </div>
            `).join('');
        }
    }
    
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const cartTotal = document.getElementById('cartTotalPrice');
    if(cartTotal) cartTotal.innerHTML = `Total: Rp ${total.toLocaleString()}`;
}

window.removeCartItem = (index) => {
    const removedItem = cart[index];
    cart.splice(index, 1);
    updateCartUI();
    showToast(`${removedItem.name} removed from cart`);
};

// ========== CHECKOUT FUNCTIONS ==========
function openCheckoutModal() {
    if(cart.length === 0) {
        showToast('Your cart is empty!', true);
        return;
    }
    document.getElementById('checkoutModal').style.display = 'flex';
    updateReceiptPreview();
}

function updateReceiptPreview() {
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const shipping = shippingCost[selectedShipping];
    const total = subtotal + shipping;
    
    const receiptItemsDiv = document.getElementById('receiptItems');
    receiptItemsDiv.innerHTML = cart.map(item => `
        <div class="summary-row">
            <span>${item.name} x${item.quantity}</span>
            <span>Rp ${(item.price * item.quantity).toLocaleString()}</span>
        </div>
    `).join('');
    
    document.getElementById('receiptSubtotal').innerHTML = `Rp ${subtotal.toLocaleString()}`;
    document.getElementById('receiptShipping').innerHTML = `Rp ${shipping.toLocaleString()}`;
    document.getElementById('receiptTotal').innerHTML = `Rp ${total.toLocaleString()}`;
}

function generateInvoiceNumber() {
    return 'INV/' + new Date().getFullYear() + '/' + 
           String(Math.floor(Math.random() * 10000)).padStart(4, '0');
}

function printReceipt(orderData) {
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
        <head><title>FurniRest - Order Receipt</title>
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; padding: 40px; }
            .receipt { max-width: 450px; margin: 0 auto; border: 1px solid #E0DCD5; padding: 25px; border-radius: 24px; }
            .header { text-align: center; border-bottom: 2px dashed #C8A86B; padding-bottom: 15px; margin-bottom: 20px; }
            .header h2 { color: #C8A86B; margin-bottom: 5px; }
            .row { display: flex; justify-content: space-between; margin-bottom: 8px; }
            .total { border-top: 2px solid #ddd; padding-top: 10px; margin-top: 10px; font-weight: bold; font-size: 1.1rem; }
            .footer { text-align: center; margin-top: 20px; font-size: 12px; color: #888; }
        </style>
        </head>
        <body>
        <div class="receipt">
            <div class="header">
                <h2>FurniRest</h2>
                <p>Premium Luxury Furniture</p>
                <p>No. Invoice: ${orderData.invoiceNo}</p>
                <p>${new Date().toLocaleString('id-ID')}</p>
            </div>
            <div><strong>Customer:</strong> ${orderData.customerName}</div>
            <div><strong>Address:</strong> ${orderData.customerAddress}</div>
            <div><strong>Phone:</strong> ${orderData.customerPhone}</div>
            <div style="margin: 15px 0;"><strong>Order Details:</strong></div>
            ${orderData.items.map(item => `<div class="row"><span>${item.name} x ${item.quantity}</span><span>Rp ${(item.price * item.quantity).toLocaleString()}</span></div>`).join('')}
            <div class="row"><span>Subtotal:</span><span>Rp ${orderData.subtotal.toLocaleString()}</span></div>
            <div class="row"><span>Shipping:</span><span>Rp ${orderData.shippingCost.toLocaleString()}</span></div>
            <div class="row total"><span>TOTAL:</span><span>Rp ${orderData.total.toLocaleString()}</span></div>
            <div class="row"><span>Payment:</span><span>${orderData.paymentMethod}</span></div>
            <div class="footer"><p>Thank you for shopping at FurniRest!</p><p>Your order will be processed soon</p></div>
        </div>
        </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
}

// ========== PRODUCT DETAIL MODAL ==========
window.openProductDetail = (id) => {
    currentProduct = products.find(p => p.id === id);
    selectedColor = currentProduct.colors[0];
    selectedSize = currentProduct.sizes[0];
    quantity = 1;
    
    const modalContent = document.getElementById('modalContent');
    modalContent.innerHTML = `
        <div class="modal-gallery">
            <img src="${currentProduct.image}" alt="${currentProduct.name}" onerror="this.src='https://placehold.co/600x400?text=No+Image'">
        </div>
        <div class="modal-details">
            <h2 class="modal-title">${currentProduct.name}</h2>
            <div class="modal-category" style="color:var(--gold); font-size:0.8rem;">${currentProduct.category} | ⭐ ${currentProduct.rating} | Sold ${currentProduct.sold}</div>
            <div class="modal-price">Rp ${currentProduct.price.toLocaleString()}</div>
            <div class="modal-desc" style="color:var(--text-muted); margin:1rem 0;">${currentProduct.desc}</div>
            <div class="variant-group">
                <div class="variant-label">Color:</div>
                <div class="variant-options" id="colorOptions"></div>
            </div>
            <div class="variant-group">
                <div class="variant-label">Size:</div>
                <div class="variant-options" id="sizeOptions"></div>
            </div>
            <div class="variant-group">
                <div class="variant-label">Quantity:</div>
                <div class="quantity-selector">
                    <button class="quantity-btn" onclick="updateQuantityModal(-1)">-</button>
                    <input id="quantityInput" type="number" value="1" min="1" readonly style="width:70px; text-align:center; border:1px solid #ddd; border-radius:12px; padding:0.5rem;">
                    <button class="quantity-btn" onclick="updateQuantityModal(1)">+</button>
                </div>
            </div>
            <button class="modal-add-cart" onclick="addToCartFromModal()"><i class="fas fa-shopping-bag"></i> Add to Cart</button>
        </div>
    `;
    
    const colorDiv = document.getElementById('colorOptions');
    colorDiv.innerHTML = currentProduct.colors.map(c => `<div class="variant-option ${c === selectedColor ? 'selected' : ''}" onclick="selectColorModal('${c}')">${c}</div>`).join('');
    
    const sizeDiv = document.getElementById('sizeOptions');
    sizeDiv.innerHTML = currentProduct.sizes.map(s => `<div class="variant-option ${s === selectedSize ? 'selected' : ''}" onclick="selectSizeModal('${s}')">${s}</div>`).join('');
    
    document.getElementById('productModal').style.display = 'flex';
};

window.selectColorModal = (color) => { 
    selectedColor = color; 
    document.querySelectorAll('#colorOptions .variant-option').forEach(opt => opt.classList.remove('selected')); 
    event.target.classList.add('selected'); 
};

window.selectSizeModal = (size) => { 
    selectedSize = size; 
    document.querySelectorAll('#sizeOptions .variant-option').forEach(opt => opt.classList.remove('selected')); 
    event.target.classList.add('selected'); 
};

window.updateQuantityModal = (delta) => { 
    quantity = Math.max(1, quantity + delta); 
    document.getElementById('quantityInput').value = quantity; 
};

window.addToCartFromModal = () => {
    addToCart(currentProduct.id, quantity, selectedColor, selectedSize);
    document.getElementById('productModal').style.display = 'none';
};

// ========== PAGE NAVIGATION ==========
function showPage(pageId) {
    document.querySelectorAll('[id$="-page"]').forEach(page => {
        page.classList.add('hidden-page');
        page.classList.remove('active-page');
    });
    document.getElementById(`${pageId}-page`).classList.remove('hidden-page');
    document.getElementById(`${pageId}-page`).classList.add('active-page');
    
    document.querySelectorAll('.nav-link, .bottom-nav-item').forEach(link => {
        link.classList.remove('active');
        if(link.getAttribute('data-page') === pageId) link.classList.add('active');
    });
    
    if(pageId === 'products') filterAndSortProducts();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function scrollToSection(sectionId) {
    const element = document.getElementById(sectionId);
    if(element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

// ========== PROFILE EDIT ==========
let isEditing = false;
const editProfileBtn = document.getElementById('editProfileBtn');
const saveProfileBtn = document.getElementById('saveProfileBtn');

if(editProfileBtn) {
    editProfileBtn.addEventListener('click', () => {
        isEditing = true;
        document.getElementById('profileName').disabled = false;
        document.getElementById('profileEmail').disabled = false;
        document.getElementById('profileAddress').disabled = false;
        document.getElementById('profilePhone').disabled = false;
        editProfileBtn.style.display = 'none';
        if(saveProfileBtn) saveProfileBtn.style.display = 'inline-block';
    });
}

if(saveProfileBtn) {
    saveProfileBtn.addEventListener('click', () => {
        isEditing = false;
        document.getElementById('profileName').disabled = true;
        document.getElementById('profileEmail').disabled = true;
        document.getElementById('profileAddress').disabled = true;
        document.getElementById('profilePhone').disabled = true;
        saveProfileBtn.style.display = 'none';
        if(editProfileBtn) editProfileBtn.style.display = 'inline-block';
        showToast('Profile saved successfully!');
    });
}

// ========== EVENT LISTENERS ==========
const checkoutBtn = document.getElementById('checkoutBtn');
const closeCart = document.getElementById('closeCart');
const cartIconBtn = document.getElementById('cartIconBtn');
const closeCheckout = document.getElementById('closeCheckout');

if(checkoutBtn) checkoutBtn.addEventListener('click', openCheckoutModal);
if(closeCart) closeCart.addEventListener('click', () => {
    document.getElementById('cartSidebar').classList.remove('open');
});
if(cartIconBtn) cartIconBtn.addEventListener('click', () => {
    document.getElementById('cartSidebar').classList.add('open');
});
if(closeCheckout) closeCheckout.addEventListener('click', () => {
    document.getElementById('checkoutModal').style.display = 'none';
});

// Shipping & Payment Options
document.querySelectorAll('.shipping-card').forEach(card => {
    card.addEventListener('click', function() {
        document.querySelectorAll('.shipping-card').forEach(c => c.classList.remove('selected'));
        this.classList.add('selected');
        selectedShipping = this.getAttribute('data-shipping');
        updateReceiptPreview();
    });
});

document.querySelectorAll('.payment-card').forEach(card => {
    card.addEventListener('click', function() {
        document.querySelectorAll('.payment-card').forEach(c => c.classList.remove('selected'));
        this.classList.add('selected');
        selectedPayment = this.getAttribute('data-bank');
        updateReceiptPreview();
    });
});

// Checkout Form Submit
const checkoutForm = document.getElementById('checkoutForm');
if(checkoutForm) {
    checkoutForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const customerName = document.getElementById('customerName').value;
        const customerAddress = document.getElementById('customerAddress').value;
        const customerPhone = document.getElementById('customerPhone').value;
        
        if(!customerName || !customerAddress || !customerPhone) {
            showToast('Please fill in all fields!', true);
            return;
        }
        
        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const orderData = {
            invoiceNo: generateInvoiceNumber(),
            customerName,
            customerAddress,
            customerPhone,
            items: cart.map(item => ({ name: item.name, quantity: item.quantity, price: item.price })),
            subtotal: subtotal,
            shippingMethod: shippingNames[selectedShipping],
            shippingCost: shippingCost[selectedShipping],
            total: subtotal + shippingCost[selectedShipping],
            paymentMethod: paymentNames[selectedPayment]
        };
        
        printReceipt(orderData);
        showToast('Order placed successfully! Receipt is printing...');
        cart = [];
        updateCartUI();
        document.getElementById('checkoutModal').style.display = 'none';
        document.getElementById('cartSidebar').classList.remove('open');
        checkoutForm.reset();
    });
}

// Modal Close
const productModal = document.getElementById('productModal');
if(productModal) {
    productModal.addEventListener('click', (e) => {
        if(e.target === productModal) {
            productModal.style.display = 'none';
        }
    });
}

document.querySelectorAll('.modal-close').forEach(closeBtn => {
    closeBtn.addEventListener('click', () => {
        document.getElementById('productModal').style.display = 'none';
    });
});

// Navigation Links
document.querySelectorAll('.nav-link, .bottom-nav-item').forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        const page = link.getAttribute('data-page');
        if(page) showPage(page);
    });
});

// Filter Buttons
const sortPopular = document.getElementById('sortPopular');
const sortPriceLow = document.getElementById('sortPriceLow');
const sortPriceHigh = document.getElementById('sortPriceHigh');
const applyPriceFilter = document.getElementById('applyPriceFilter');

if(sortPopular) sortPopular.addEventListener('click', () => { currentSort = "popular"; filterAndSortProducts(); });
if(sortPriceLow) sortPriceLow.addEventListener('click', () => { currentSort = "priceLow"; filterAndSortProducts(); });
if(sortPriceHigh) sortPriceHigh.addEventListener('click', () => { currentSort = "priceHigh"; filterAndSortProducts(); });
if(applyPriceFilter) applyPriceFilter.addEventListener('click', () => {
    const minInput = document.getElementById('minPrice');
    const maxInput = document.getElementById('maxPrice');
    minPriceFilter = parseInt(minInput?.value) || 0;
    maxPriceFilter = parseInt(maxInput?.value) || 10000000;
    filterAndSortProducts();
});

document.querySelectorAll('.filter-btn[data-filter]').forEach(btn => {
    btn.addEventListener('click', () => {
        currentFilter = btn.getAttribute('data-filter');
        filterAndSortProducts();
        document.querySelectorAll('.filter-btn[data-filter]').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    });
});

// ========== ORDER FORM FUNCTIONS ==========
function openOrderForm(productId, productName, price) {
    document.getElementById('orderProductId').value = productId;
    document.getElementById('orderProductName').value = productName;
    document.getElementById('orderProductPrice').value = price;
    document.getElementById('orderQuantity').value = 1;
    updateTotal();
    document.getElementById('orderModal').classList.add('active');
}

function closeOrderForm() {
    document.getElementById('orderModal').classList.remove('active');
}

function updateTotal() {
    const quantity = parseInt(document.getElementById('orderQuantity').value) || 1;
    const price = parseInt(document.getElementById('orderProductPrice').value) || 0;
    const total = price * quantity;
    document.getElementById('orderTotalPrice').textContent = 'Rp ' + total.toLocaleString('id-ID');
}

// ========== INITIALIZE APP ==========
document.addEventListener('DOMContentLoaded', () => {
    renderCategories();
    // Render featured / popular products (limit 8)
    renderProducts('popularProducts', products.slice(0, 8));
    // Render full product list for products page
    renderProducts('allProductsGrid', products);
    setupSearch();
    setupNewsletter();
    updateCartUI();

    // create on-page debug badge after init
    try {
        const badge = document.createElement('div');
        badge.id = 'debugBadge';
        badge.style.position = 'fixed';
        badge.style.right = '12px';
        badge.style.bottom = '12px';
        badge.style.zIndex = 99999;
        badge.style.background = 'rgba(0,0,0,0.7)';
        badge.style.color = '#fff';
        badge.style.fontSize = '12px';
        badge.style.padding = '8px 10px';
        badge.style.borderRadius = '8px';
        badge.style.boxShadow = '0 6px 18px rgba(0,0,0,0.4)';
        badge.style.fontFamily = 'sans-serif';
        const popular = !!document.getElementById('popularProducts');
        const all = !!document.getElementById('allProductsGrid');
        const cat = !!document.getElementById('categoryGrid');
        badge.innerText = `script.js loaded — products:${products.length} | popular:${popular} | all:${all} | cat:${cat}`;
        document.body.appendChild(badge);
    } catch(e) {
        console.error('Badge error', e);
    }
});