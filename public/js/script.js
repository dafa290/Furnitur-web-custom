// ============ 1. CAROUSEL PROMO (Banner Iklan) ============
// Bagian ini mengatur pergerakan banner promo secara otomatis dan manual.
let currentSlideAd = 0;
let slidesAd = [];
let dotsAd = [];
let slideIntervalAd;
let isTransitioning = false;

function initCarousel() {
    slidesAd = document.querySelectorAll('.carousel-slide-ad');
    dotsAd = document.querySelectorAll('.dot-ad');
    if (!slidesAd.length) return;
    showSlideAd(0);
    startAutoSlide(); // Mulai geser otomatis setiap 5 detik
}

function showSlideAd(index) {
    if (isTransitioning || !slidesAd.length) return;
    if (index >= slidesAd.length) index = 0;
    if (index < 0) index = slidesAd.length - 1;
    
    isTransitioning = true;
    currentSlideAd = index;
    
    const offset = -currentSlideAd * 100;
    const slidesContainer = document.querySelector('.carousel-slides-ads');
    if (slidesContainer) slidesContainer.style.transform = `translateX(${offset}%)`;
    
    slidesAd.forEach((slide, i) => slide.classList.toggle('active', i === currentSlideAd));
    dotsAd.forEach((dot, i) => dot.classList.toggle('active', i === currentSlideAd));
    
    setTimeout(() => { isTransitioning = false; }, 500);
}

function nextSlideAd() {
    if (isTransitioning) return;
    currentSlideAd++;
    if (currentSlideAd >= slidesAd.length) currentSlideAd = 0;
    showSlideAd(currentSlideAd);
    resetAutoSlide();
}

function prevSlideAd() {
    if (isTransitioning) return;
    currentSlideAd--;
    if (currentSlideAd < 0) currentSlideAd = slidesAd.length - 1;
    showSlideAd(currentSlideAd);
    resetAutoSlide();
}

function goToSlideAd(index) {
    if (isTransitioning || index === currentSlideAd) return;
    currentSlideAd = index;
    showSlideAd(currentSlideAd);
    resetAutoSlide();
}

function startAutoSlide() {
    if (slideIntervalAd) clearInterval(slideIntervalAd);
    slideIntervalAd = setInterval(() => {
        if (!isTransitioning) {
            currentSlideAd++;
            if (currentSlideAd >= slidesAd.length) currentSlideAd = 0;
            showSlideAd(currentSlideAd);
        }
    }, 5000);
}

function resetAutoSlide() {
    if (slideIntervalAd) { clearInterval(slideIntervalAd); startAutoSlide(); }
}

// ============ 2. DATA PRODUK (Fetch dari API) ============
// Fungsi ini mengambil data produk dari database melalui Laravel API.
let allProducts = [];

async function fetchProducts() {
    try {
        const response = await fetch('/api/products');
        allProducts = await response.json();
        renderProducts(allProducts); // Tampilkan produk ke layar
    } catch (error) {
        console.error('Error fetching products:', error);
        // Fallback to sample data if API fails
        allProducts = [
            { id: 1, name: 'Kursi Rektor Oak', category: 'Kursi', price: 2800000, material: 'Kayu', color: 'Natural', badge: 'Terlaris', img: 'https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?w=500&h=400&fit=crop' },
            { id: 2, name: 'Meja Vittoria Marble', category: 'Meja', price: 6500000, material: 'Metal', color: 'Charcoal', badge: 'Baru', img: 'https://images.unsplash.com/photo-1533090481720-856c6e3c1fdc?w=500&h=400&fit=crop' },
        ];
        renderProducts(allProducts);
    }
}

let activeColor = null;
let activeCategoryTop = null;

function formatRp(n) { return 'Rp ' + (n || 0).toLocaleString('id-ID'); }

function renderProducts(list) {
    const grid = document.getElementById('productGrid');
    if (!grid) return;
    if (!list.length) { grid.innerHTML = '<div class="no-products"><i class="fas fa-box-open"></i><p>Tidak ada produk ditemukan</p></div>'; return; }
    grid.innerHTML = list.map(p => `
        <div class="product-card" onclick="window.location.href='/product/${p.id}'">
            <div class="product-img-wrap"><img src="${p.img || 'https://via.placeholder.com/500x400?text=No+Image'}" alt="${p.name}" loading="lazy">${p.badge ? `<div class="product-badge">${p.badge}</div>` : ''}</div>
            <div class="product-info">
                <div class="product-category">${p.category || 'Furniture'}</div>
                <div class="product-name">${p.name}</div>
                <div class="product-meta">${p.material || '-'} • ${p.color || '-'}</div>
                <div class="product-footer">
                    <div class="product-price">${formatRp(p.price)}</div>
                    <div class="product-actions">
                        <div class="btn-wishlist" onclick="event.stopPropagation();addToWishlist(${p.id})"><i class="far fa-heart"></i></div>
                        <div class="btn-cart" onclick="event.stopPropagation();addToCart(${p.id})"><i class="fas fa-shopping-bag"></i></div>
                    </div>
                </div>
            </div>
        </div>
    `).join('');
}

function getFiltered() {
    const searchInput = document.getElementById('searchInput');
    const priceSlider = document.getElementById('priceSlider');
    const search = searchInput ? searchInput.value.toLowerCase() : '';
    const maxPrice = priceSlider ? parseInt(priceSlider.value) : 25000000;
    const checkedCats = [...document.querySelectorAll('#categoryFilter input:checked')].map(c => c.value);
    const checkedMats = [...document.querySelectorAll('#materialFilter input:checked')].map(c => c.value);
       return allProducts.filter(p => {
        if (search && !p.name.toLowerCase().includes(search)) return false;
        if (p.price > maxPrice) return false;
        if (checkedCats.length && !checkedCats.includes(p.category)) return false;
        if (checkedMats.length && !checkedMats.includes(p.material)) return false;
        if (activeColor && p.color !== activeColor) return false;
        return true;
    });
}

function applyFilters() { renderProducts(getFiltered()); }
function filterByCategory(cat) {
    activeCategoryTop = cat;
    document.querySelectorAll('#categoryFilter input').forEach(cb => cb.checked = cb.value === cat);
    document.querySelectorAll('.cat-card').forEach(c => c.classList.toggle('active', c.dataset.cat === cat));
    applyFilters();
    const section = document.getElementById('productsSection');
    if (section) section.scrollIntoView({ behavior: 'smooth', block: 'start' });
}
function filterByColor(col) { activeColor = (activeColor === col) ? null : col; document.querySelectorAll('.swatch').forEach(s => s.classList.toggle('active', s.dataset.color === activeColor)); applyFilters(); }
function scrollToProducts() { 
    const section = document.getElementById('productsSection');
    if (section) section.scrollIntoView({ behavior: 'smooth', block: 'start' }); 
}
function showToast(msg) { const toast = document.getElementById('toastMsg'); if (!toast) return; toast.textContent = msg; toast.classList.add('show'); setTimeout(() => toast.classList.remove('show'), 2500); }
function showSocialNotification(name) { showToast(`Menuju halaman ${name}`); }
function toggleSearchBar() { const bar = document.getElementById('navbarSearchBar'); if (bar) bar.style.display = bar.style.display === 'none' ? 'block' : 'none'; }

// Event Listeners Initialization
function initEventListeners() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) searchInput.addEventListener('input', applyFilters);
    
    const priceSlider = document.getElementById('priceSlider');
    if (priceSlider) {
        priceSlider.addEventListener('input', function() { 
            const val = parseInt(this.value); 
            const label = document.getElementById('maxPriceLabel');
            if (label) label.textContent = val >= 25000000 ? 'Rp 25.000.000+' : formatRp(val); 
            applyFilters(); 
        });
    }
    
    document.querySelectorAll('#categoryFilter input, #materialFilter input').forEach(cb => cb.addEventListener('change', applyFilters));
    
    const resetCategory = document.getElementById('resetCategory');
    if (resetCategory) {
        resetCategory.addEventListener('click', () => { 
            document.querySelectorAll('#categoryFilter input').forEach(cb => cb.checked = false); 
            document.querySelectorAll('.cat-card').forEach(c => c.classList.remove('active')); 
            activeCategoryTop = null; 
            applyFilters(); 
        });
    }
    
    const resetPrice = document.getElementById('resetPrice');
    if (resetPrice) {
        resetPrice.addEventListener('click', () => { 
            const slider = document.getElementById('priceSlider'); 
            if (slider) {
                slider.value = 25000000; 
                const label = document.getElementById('maxPriceLabel');
                if (label) label.textContent = 'Rp 25.000.000+'; 
                applyFilters(); 
            }
        });
    }

    // Navbar search sync
    const navbarSearch = document.getElementById('navbarSearchInput');
    const sidebarSearch = document.getElementById('searchInput');
    if (navbarSearch) {
        navbarSearch.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                if (sidebarSearch) {
                    sidebarSearch.value = this.value;
                    sidebarSearch.dispatchEvent(new Event('input'));
                } else {
                    // Not on home page, redirect to home with search param
                    window.location.href = '/home?q=' + encodeURIComponent(this.value);
                }
            }
        });
        
        if (sidebarSearch) {
            navbarSearch.addEventListener('input', function(e) { 
                sidebarSearch.value = e.target.value; 
                sidebarSearch.dispatchEvent(new Event('input')); 
            });
        }
    }
}

// Check for search param in URL
function checkUrlParams() {
    const urlParams = new URLSearchParams(window.location.search);
    const query = urlParams.get('q');
    if (query) {
        const sidebarSearch = document.getElementById('searchInput');
        const navbarSearch = document.getElementById('navbarSearchInput');
        if (sidebarSearch) sidebarSearch.value = query;
        if (navbarSearch) navbarSearch.value = query;
        // The fetchProducts call will eventually call applyFilters
    }
}

// Helper to get CSRF token
function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
}

// ============ 3. MANAJEMEN KERANJANG (Cart System) ============
// Bagian ini mengatur sinkronisasi antara keranjang di browser (localStorage) 
// dan keranjang di database (jika user sudah login).

async function updateCartBadge() {
    try {
        const response = await fetch('/api/cart');
        const data = await response.json();
        // Jika login, ambil jumlah dari server. Jika tidak, ambil dari localStorage.
        let count = data.loggedIn ? (data.count || 0) : JSON.parse(localStorage.getItem('cart') || '[]').reduce((sum, item) => sum + (item.quantity || 1), 0);
        const badge = document.getElementById('cartBadge');
        if (badge) {
            if (count > 0) { badge.textContent = count; badge.style.display = 'flex'; } 
            else { badge.style.display = 'none'; }
        }
    } catch (error) { 
        const count = JSON.parse(localStorage.getItem('cart') || '[]').reduce((sum, item) => sum + (item.quantity || 1), 0); 
        const badge = document.getElementById('cartBadge'); 
        if (badge) {
            if (count > 0) { badge.textContent = count; badge.style.display = 'flex'; } 
            else { badge.style.display = 'none'; } 
        }
    }
}

// Sync localStorage cart to DB
async function syncCart() {
    const localCart = JSON.parse(localStorage.getItem('cart') || '[]');
    if (localCart.length === 0) return;

    try {
        const response = await fetch('/api/cart');
        const data = await response.json();
        if (data.loggedIn) {
            await fetch('/api/cart/sync', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken()
                },
                body: JSON.stringify({ items: localCart })
            });
            localStorage.removeItem('cart');
            updateCartBadge();
        }
    } catch (e) { console.error('Sync failed', e); }
}

window.addToCart = async function(productId, quantity = 1) {
    let product = allProducts.find(p => p.id === productId);
    
    // If not in allProducts (e.g. on detail page), we can use the data from the page
    if (!product) {
        const detailImg = document.getElementById('productImage')?.src;
        const detailName = document.getElementById('productName')?.textContent;
        const detailPriceRaw = document.getElementById('productPrice')?.textContent || '0';
        const detailPrice = parseInt(detailPriceRaw.replace(/[^0-9]/g, ''));
        
        if (detailName && detailPrice) {
            product = { id: productId, name: detailName, price: detailPrice, img: detailImg };
        }
    }

    if (!product) {
        try {
            const resp = await fetch(`/api/products/${productId}`);
            product = await resp.json();
        } catch (e) {
            console.error('Fetch product failed', e);
        }
    }

    if (product && product.id) {
        await performAddToCart(product, quantity);
    } else {
        showToast('❌ Gagal mendapatkan data produk');
    }
};

async function performAddToCart(product, quantity = 1) {
    try {
        const cartResponse = await fetch('/api/cart');
        const cartData = await cartResponse.json();
        
        if (cartData.loggedIn) { 
            const response = await fetch('/api/cart/add', { 
                method: 'POST', 
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken()
                }, 
                body: JSON.stringify({ 
                    id: product.id, 
                    name: product.name, 
                    price: product.price,
                    img: product.img || product.image_url,
                    quantity: quantity
                }) 
            }); 
            
            if (response.ok) {
                showToast(`✅ ${product.name} ditambahkan ke keranjang`); 
            } else {
                const err = await response.json();
                showToast(`❌ Gagal: ${err.error || 'Terjadi kesalahan'}`);
            }
        }
        else { 
            let localCart = JSON.parse(localStorage.getItem('cart') || '[]'); 
            const existing = localCart.find(item => item.id === product.id); 
            if (existing) {
                existing.quantity = (existing.quantity || 1) + quantity;
                if (product.img || product.image_url) existing.img = product.img || product.image_url;
            } else {
                localCart.push({ 
                    id: product.id, 
                    name: product.name, 
                    price: product.price, 
                    quantity: quantity, 
                    img: product.img || product.image_url 
                }); 
            }
            localStorage.setItem('cart', JSON.stringify(localCart)); 
            showToast(`✅ ${product.name} ditambahkan ke keranjang`); 
        }
        updateCartBadge();
    } catch (error) { 
        console.error(error);
        showToast('❌ Gagal menambahkan ke keranjang');
    }
}

window.addToWishlist = async function(productId) { 
    try {
        const cartResponse = await fetch('/api/cart');
        const cartData = await cartResponse.json();
        if (!cartData.loggedIn) {
            showToast('⚠️ Silakan login untuk simpan wishlist');
            return;
        }

        let product = allProducts.find(p => p.id === productId);
        if (!product) {
            const resp = await fetch(`/api/products/${productId}`);
            product = await resp.json();
        }

        if (product) {
            const response = await fetch('/api/wishlist/add', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': getCsrfToken() 
                },
                body: JSON.stringify({ 
                    productId: product.id,
                    productName: product.name,
                    productPrice: product.price,
                    productImg: product.img || product.image_url
                })
            });
            const res = await response.json();
            if (res.success) {
                showToast('❤️ Ditambahkan ke wishlist');
            } else {
                showToast('❤️ ' + (res.message || 'Sudah ada di wishlist'));
            }
        }
    } catch (e) { 
        console.error('Wishlist failed', e);
        showToast('❌ Gagal menambahkan ke wishlist'); 
    }
};

// Dropdown function
window.toggleDropdown = function() {
    const dropdown = document.getElementById('profileDropdown');
    if (dropdown) {
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }
}

// Close dropdown when clicking outside
window.addEventListener('click', function(event) {
    const dropdown = document.getElementById('profileDropdown');
    const trigger = document.querySelector('.nav-user-name');
    if (dropdown && trigger && !trigger.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.style.display = 'none';
    }
});

// Initialize on Load
document.addEventListener('DOMContentLoaded', () => {
    checkUrlParams();
    fetchProducts();
    updateCartBadge();
    syncCart();
    initCarousel();
    initEventListeners();
});