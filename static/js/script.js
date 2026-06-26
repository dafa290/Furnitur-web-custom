// ============ DATA PRODUK ============
let products = [
    { id:1, name:"Amara Lounge Chair", price:4850000, category:"Kursi", color:"Natural", material:"Kayu", stock:15, img:"https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?w=600&h=450&fit=crop" },
    { id:2, name:"Nara Coffee Table", price:3250000, category:"Meja", color:"Walnut", material:"Kayu", stock:23, img:"https://images.unsplash.com/photo-1533090481720-856c6e3c1fdc?w=600&h=450&fit=crop" },
    { id:3, name:"Orion Wardrobe", price:12450000, category:"Lemari", color:"Natural", material:"Kayu", stock:8, img:"https://images.unsplash.com/photo-1595428774223-ef52624120d2?w=600&h=450&fit=crop" },
    { id:4, name:"Serene Bed Frame", price:9850000, category:"Tempat Tidur", color:"Beige", material:"Kayu", stock:12, img:"https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=600&h=450&fit=crop" },
    { id:5, name:"Lumina Sofa", price:14300000, category:"Sofa", color:"Olive", material:"Fabric", stock:6, img:"https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=600&h=450&fit=crop" },
    { id:6, name:"Strada Dining Chair", price:2950000, category:"Kursi", color:"Charcoal", material:"Metal", stock:35, img:"https://images.unsplash.com/photo-1592078615290-033ee584e267?w=600&h=450&fit=crop" },
    { id:7, name:"Solace Desk", price:4350000, category:"Meja", color:"Walnut", material:"Kayu", stock:18, img:"https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd?w=600&h=450&fit=crop" },
    { id:8, name:"Cielo Sideboard", price:6850000, category:"Lemari", color:"Natural", material:"Kayu", stock:10, img:"https://images.unsplash.com/photo-1615873968403-89e0686299f4?w=600&h=450&fit=crop" },
    { id:9, name:"Breeze Daybed", price:11900000, category:"Tempat Tidur", color:"Beige", material:"Fabric", stock:5, img:"https://images.unsplash.com/photo-1505693314120-0d2d56d1f131?w=600&h=450&fit=crop" },
    { id:10, name:"Milo Armchair", price:5650000, category:"Kursi", color:"Olive", material:"Fabric", stock:14, img:"https://images.unsplash.com/photo-1580480055273-228ff5388ef8?w=600&h=450&fit=crop" },
    { id:11, name:"Axis Modular Sofa", price:18900000, category:"Sofa", color:"Charcoal", material:"Fabric", stock:4, img:"https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?w=600&h=450&fit=crop" },
    { id:12, name:"Terra Console", price:3590000, category:"Meja", color:"Walnut", material:"Metal", stock:22, img:"https://images.unsplash.com/photo-1616486338812-3aadae4b4ace?w=600&h=450&fit=crop" },
    { id:13, name:"Flora Bookshelf", price:4950000, category:"Lemari", color:"Natural", material:"Kayu", stock:16, img:"https://images.unsplash.com/photo-1594620302200-9a762244a3bc?w=600&h=450&fit=crop" },
    { id:14, name:"Velvet Ottoman", price:2250000, category:"Kursi", color:"Olive", material:"Fabric", stock:28, img:"https://images.unsplash.com/photo-1581539250439-c96689b516dd?w=600&h=450&fit=crop" }
];

// ============ KERANJANG DENGAN DATABASE ============
let cart = [];
let isLoggedIn = false;

async function loadCartFromServer() {
    try {
        const response = await fetch('/api/cart');
        const data = await response.json();
        
        if (data.loggedIn) {
            isLoggedIn = true;
            cart = data.items.map(item => ({
                id: item.id,
                name: item.name,
                price: item.price,
                quantity: item.quantity
            }));
            updateCartBadge();
            if (typeof displayCart === 'function') displayCart();
        } else {
            loadCartFromLocalStorage();
        }
    } catch (error) {
        console.error('Error loading cart:', error);
        loadCartFromLocalStorage();
    }
}

function loadCartFromLocalStorage() {
    cart = JSON.parse(localStorage.getItem('cart') || '[]');
    console.log('Loaded from localStorage:', cart); // Cek di console
    updateCartBadge();
}

function toggleSearchBar() {
    const searchBar = document.getElementById('navbarSearchBar');
    if (searchBar.style.display === 'none' || searchBar.style.display === '') {
        searchBar.style.display = 'block';
        document.getElementById('navbarSearchInput').focus();
    } else {
        searchBar.style.display = 'none';
    }
}

// Event listener untuk search di navbar
document.getElementById('navbarSearchInput')?.addEventListener('input', function(e) {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.value = e.target.value;
        searchInput.dispatchEvent(new Event('input'));
    }
});

async function addToCart(productId, productName, productPrice) {
    const product = products.find(p => p.id === productId);
    if (!product) return;
    
    const existingItem = cart.find(item => item.id === productId);
    let currentQty = existingItem ? existingItem.quantity : 0;
    
    if (currentQty >= product.stock) {
        showToast(`⚠️ Stok ${product.name} hanya ${product.stock}!`);
        return;
    }
    
    if (isLoggedIn) {
        try {
            const response = await fetch('/api/cart/add', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: productId, name: productName, price: productPrice })
            });
            
            if (response.ok) {
                showToast(`✅ ${productName} ditambahkan ke keranjang`);
                loadCartFromServer();
            }
        } catch (error) {
            addToLocalCart(productId, productName, productPrice);
        }
    } else {
        addToLocalCart(productId, productName, productPrice);
    }
}

function addToLocalCart(productId, productName, productPrice) {
    const existing = cart.find(item => item.id === productId);
    if (existing) {
        existing.quantity++;
    } else {
        cart.push({ id: productId, name: productName, price: productPrice, quantity: 1 });
    }
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartBadge();
    showToast(`✅ ${productName} ditambahkan ke keranjang (local)`);
}

async function syncLocalCartToServer() {
    if (!isLoggedIn) return;
    
    const localCart = JSON.parse(localStorage.getItem('cart') || '[]');
    if (localCart.length === 0) return;
    
    try {
        await fetch('/api/cart/sync', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ items: localCart })
        });
        localStorage.removeItem('cart');
        loadCartFromServer();
        showToast('🔄 Keranjang berhasil disinkronkan');
    } catch (error) {
        console.error('Sync error:', error);
    }
}

function updateCartBadge() {
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    let badge = document.querySelector('.cart-badge');
    
    if (!badge && totalItems > 0) {
        const cartIcon = document.querySelector('.fa-shopping-bag');
        if (cartIcon && cartIcon.parentElement) {
            badge = document.createElement('span');
            badge.className = 'cart-badge';
            cartIcon.parentElement.style.position = 'relative';
            cartIcon.parentElement.appendChild(badge);
        }
    }
    
    if (badge) {
        if (totalItems > 0) {
            badge.textContent = totalItems;
            badge.style.display = 'flex';
        } else {
            badge.style.display = 'none';
        }
    }
}

// ============ DOM ELEMENTS ============
const grid = document.getElementById('productGrid');
const catCheckboxes = document.querySelectorAll('#sidebarCategoryFilter input');
const priceSlider = document.getElementById('priceSlider');
const maxPriceSpan = document.getElementById('maxPriceLabel');
const swatchDivs = document.querySelectorAll('.swatch-3d');
const materialCheck = document.querySelectorAll('#materialFilter input');
const resetCategoryBtn = document.getElementById('resetCategoryFilter');
const resetPriceBtn = document.getElementById('resetPriceRange');
const categoryCards = document.querySelectorAll('.cat-card-3d');
const toastMsgDiv = document.getElementById('toastMsg');

// ============ STATE ============
let selectedCategories = new Set();
let maxPriceVal = 25000000;
let selectedColor = null;
let selectedMaterials = new Set();

// ============ FUNGSI ============
function formatIDR(val) {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(val);
}

function showToast(text) {
    toastMsgDiv.textContent = text;
    toastMsgDiv.classList.add('show');
    setTimeout(() => toastMsgDiv.classList.remove('show'), 2100);
}

function removeFromCart(productId) {
    if (isLoggedIn) {
        fetch('/api/cart/remove', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: productId })
        }).then(() => loadCartFromServer());
    } else {
        cart = cart.filter(item => item.id !== productId);
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartBadge();
        if (typeof displayCart === 'function') displayCart();
    }
    showToast('🗑️ Produk dihapus dari keranjang');
}

function checkout() {
    if (cart.length === 0) {
        showToast('🛒 Keranjang kosong!');
        return;
    }
    window.location.href = '/checkout';
}

// ============ RENDER PRODUCTS ============
function renderProducts() {
    let filtered = [...products];
    
    if (selectedCategories.size > 0) {
        filtered = filtered.filter(p => selectedCategories.has(p.category));
    }
    filtered = filtered.filter(p => p.price <= maxPriceVal);
    if (selectedColor) {
        filtered = filtered.filter(p => p.color === selectedColor);
    }
    if (selectedMaterials.size > 0) {
        filtered = filtered.filter(p => selectedMaterials.has(p.material));
    }
    
    if (filtered.length === 0) {
        grid.innerHTML = `<div style="grid-column:1/-1; text-align:center; padding:60px;">
            <i class="fas fa-search" style="font-size:48px; color:#a855f7; margin-bottom:16px; display:block;"></i>
            <p style="color:rgba(255,255,255,0.7);">Tidak ada produk sesuai filter</p>
        </div>`;
        return;
    }
    
    grid.innerHTML = filtered.map(prod => {
        const cartItem = cart.find(item => item.id === prod.id);
        const qtyInCart = cartItem ? cartItem.quantity : 0;
        const isOutOfStock = prod.stock === 0;
        const isMaxStock = qtyInCart >= prod.stock;
        
        return `
            <div class="product-card-3d">
                <div class="product-img-3d" onclick="window.location.href='/product/${prod.id}'">
                    <img src="${prod.img}" alt="${prod.name}" loading="lazy">
                </div>
                <div class="product-info-3d">
                    <div class="product-name-3d" onclick="window.location.href='/product/${prod.id}'">${prod.name}</div>
                    <div class="product-price-3d">${formatIDR(prod.price)}</div>
                    <div style="font-size:12px; color:rgba(255,255,255,0.5); margin-bottom:10px;">
                        Stok: ${prod.stock} ${qtyInCart > 0 ? `| Di keranjang: ${qtyInCart}` : ''}
                    </div>
                    <button class="btn-cart-3d" 
                        onclick="addToCart(${prod.id}, '${prod.name}', ${prod.price})"
                        ${isOutOfStock ? 'disabled style="opacity:0.5; cursor:not-allowed;"' : ''}>
                        <i class="fas fa-shopping-cart"></i> 
                        ${isOutOfStock ? 'Stok Habis' : (isMaxStock ? 'Stok Maksimal' : 'Tambah ke Keranjang')}
                    </button>
                </div>
            </div>
        `;
    }).join('');
}

// ============ FILTER FUNCTIONS ============
function syncFiltersAndRender() {
    renderProducts();
    categoryCards.forEach(card => {
        const catVal = card.getAttribute('data-cat');
        if (selectedCategories.has(catVal)) {
            card.classList.add('active');
        } else {
            card.classList.remove('active');
        }
    });
}

function filterByCategory(category) {
    const checkbox = Array.from(catCheckboxes).find(cb => cb.value === category);
    if (checkbox) {
        checkbox.checked = !checkbox.checked;
        if (checkbox.checked) {
            selectedCategories.add(category);
        } else {
            selectedCategories.delete(category);
        }
        syncFiltersAndRender();
    }
}

function filterByColor(color) {
    const swatch = Array.from(swatchDivs).find(s => s.getAttribute('data-color') === color);
    if (selectedColor === color) {
        selectedColor = null;
        swatch.classList.remove('active');
    } else {
        selectedColor = color;
        swatchDivs.forEach(s => s.classList.remove('active'));
        swatch.classList.add('active');
    }
    renderProducts();
}

// ============ NAVIGATION ============
function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function scrollToProducts() {
    document.getElementById('productsSection').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function navigateTo(section) {
    if (section === 'home') {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    } else if (section === 'produk') {
        scrollToProducts();
    } else if (section === 'kategori') {
        document.querySelector('.category-scroll-3d')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    } else if (section === 'kontak') {
        document.querySelector('.footer-3d')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

function showSearchNotification() { showToast('🔍 Fitur pencarian akan segera hadir'); }
function showCartNotification() { 
    window.location.href = '/checkout';
}
function showSocialNotification(platform) { showToast(`📱 Ikuti kami di ${platform}`); }

// ============ PARTICLE ANIMATION ============
const canvas = document.getElementById('particleCanvas');
if (canvas) {
    const ctx = canvas.getContext('2d');
    function resizeCanvas() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    }
    const particles = [];
    for (let i = 0; i < 100; i++) {
        particles.push({
            x: Math.random() * window.innerWidth,
            y: Math.random() * window.innerHeight,
            radius: Math.random() * 3 + 1,
            speedX: (Math.random() - 0.5) * 0.5,
            speedY: (Math.random() - 0.5) * 0.5,
            color: `rgba(168, 85, 247, ${Math.random() * 0.5})`
        });
    }
    function animateParticles() {
        if (!ctx) return;
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        particles.forEach(p => {
            p.x += p.speedX;
            p.y += p.speedY;
            if (p.x < 0) p.x = canvas.width;
            if (p.x > canvas.width) p.x = 0;
            if (p.y < 0) p.y = canvas.height;
            if (p.y > canvas.height) p.y = 0;
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
            ctx.fillStyle = p.color;
            ctx.fill();
        });
        requestAnimationFrame(animateParticles);
    }
    window.addEventListener('resize', resizeCanvas);
    resizeCanvas();
    animateParticles();
}

// ============ EVENT LISTENERS ============
catCheckboxes.forEach(cb => {
    cb.addEventListener('change', (e) => {
        const val = cb.value;
        if (cb.checked) {
            selectedCategories.add(val);
        } else {
            selectedCategories.delete(val);
        }
        syncFiltersAndRender();
    });
});

priceSlider.addEventListener('input', (e) => {
    maxPriceVal = parseInt(e.target.value);
    maxPriceSpan.innerText = maxPriceVal >= 25000000 ? 'Rp 25.000.000+' : formatIDR(maxPriceVal);
    renderProducts();
});

resetPriceBtn.addEventListener('click', () => {
    priceSlider.value = '25000000';
    maxPriceVal = 25000000;
    maxPriceSpan.innerText = 'Rp 25.000.000+';
    renderProducts();
});

resetCategoryBtn.addEventListener('click', () => {
    selectedCategories.clear();
    catCheckboxes.forEach(cb => cb.checked = false);
    syncFiltersAndRender();
});

materialCheck.forEach(m => {
    m.addEventListener('change', () => {
        const matVal = m.value;
        if (m.checked) {
            selectedMaterials.add(matVal);
        } else {
            selectedMaterials.delete(matVal);
        }
        renderProducts();
    });
});

// ============ INIT ============
function init() {
    renderProducts();
    priceSlider.value = '25000000';
    maxPriceVal = 25000000;
    maxPriceSpan.innerText = 'Rp 25.000.000+';
    updateCartBadge();
}
init();

// Panggil loadCartFromServer saat halaman load
loadCartFromServer();

// Setelah login sukses, sync cart
function afterLoginSync() {
    isLoggedIn = true;
    syncLocalCartToServer();
}