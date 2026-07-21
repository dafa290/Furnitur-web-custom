<?php
session_start();
if(!isset($_SESSION['furni_admin']) || $_SESSION['furni_admin'] !== true) {
    header('Location: login.php');
    exit;
}

require_once '../config.php';

// Ambil semua produk
$stmt = $db->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// PERBAIKAN: order_date (bukan created_at)
$stmtOrders = $db->query("SELECT * FROM orders ORDER BY order_date DESC");
$orders = $stmtOrders->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FurniRest</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="admin-nav">
        <div class="nav-brand">
            <i class="fas fa-couch"></i> FurniRest <span>Admin</span>
        </div>
        <div class="nav-menu">
            <button class="nav-btn active" data-tab="products">
                <i class="fas fa-box"></i> Produk
            </button>
            <button class="nav-btn" data-tab="orders">
                <i class="fas fa-shopping-cart"></i> Pesanan
            </button>
            <a href="logout.php" class="nav-btn logout">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </nav>

    <div class="admin-container">
        <div class="stats-row">
            <div class="stat-box">
                <i class="fas fa-boxes"></i>
                <div class="stat-number"><?= count($products) ?></div>
                <div class="stat-label">Total Produk</div>
            </div>
            <div class="stat-box">
                <i class="fas fa-shopping-cart"></i>
                <div class="stat-number"><?= count($orders) ?></div>
                <div class="stat-label">Total Pesanan</div>
            </div>
        </div>

        <!-- Tab Produk -->
        <div id="productsTab" class="admin-tab active">
            <div class="tab-header">
                <h2><i class="fas fa-box"></i> Daftar Produk</h2>
                <button class="btn-add" onclick="openProductModal()">
                    <i class="fas fa-plus"></i> Tambah Produk
                </button>
            </div>
            
            <div class="products-grid">
                <?php foreach($products as $product): ?>
                <div class="product-item">
                    <img src="<?= htmlspecialchars($product['image'] ?? 'https://placehold.co/300x200?text=No+Image') ?>" 
                         onerror="this.src='https://placehold.co/300x200?text=No+Image'">
                    <div class="product-detail">
                        <h3><?= htmlspecialchars($product['name']) ?></h3>
                        <p class="category"><?= htmlspecialchars($product['category'] ?? '-') ?></p>
                        <p class="price">Rp <?= number_format($product['price'], 0, ',', '.') ?></p>
                    </div>
                    <div class="product-actions">
                        <button class="edit-btn" onclick="editProduct(<?= $product['id'] ?>)">Edit</button>
                        <button class="delete-btn" onclick="deleteProduct(<?= $product['id'] ?>)">Hapus</button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Tab Pesanan -->
        <div id="ordersTab" class="admin-tab">
            <div class="tab-header">
                <h2><i class="fas fa-shopping-cart"></i> Daftar Pesanan</h2>
            </div>
            <div class="table-wrapper">
                <table class="orders-table">
                    <thead>
                        <tr><th>ID</th><th>Customer</th><th>Produk</th><th>Qty</th><th>Total</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach($orders as $order): ?>
                        <tr>
                            <td>#<?= $order['id'] ?></td>
                            <td>
                                <strong><?= htmlspecialchars($order['customer_name']) ?></strong><br>
                                <small><?= htmlspecialchars($order['customer_phone']) ?></small>
                            </td>
                            <td><?= htmlspecialchars($order['product_name'] ?? '-') ?></td>
                            <td><?= $order['quantity'] ?></td>
                            <td>Rp <?= number_format($order['total_price'], 0, ',', '.') ?></td>
                            <td>
                                <select class="status-select" data-id="<?= $order['id'] ?>" onchange="updateStatus(this)">
                                    <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="processing" <?= $order['status'] == 'processing' ? 'selected' : '' ?>>Processing</option>
                                    <option value="completed" <?= $order['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                                </select>
                            </td>
                            <td><?= date('d/m/Y', strtotime($order['order_date'])) ?></td>
                            <td>
                                <button class="delete-order-btn" onclick="deleteOrder(<?= $order['id'] ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Product -->
    <div id="productModal" class="modal">
        <div class="modal-box">
            <div class="modal-header">
                <h3 id="modalTitle">Tambah Produk</h3>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <form id="productForm">
                <input type="hidden" id="productId">
                <div class="form-field">
                    <label>Nama Produk</label>
                    <input type="text" id="productName" required>
                </div>
                <div class="form-row">
                    <div class="form-field">
                        <label>Kategori</label>
                        <input type="text" id="productCategory" placeholder="Sofa, Meja, Kursi">
                    </div>
                    <div class="form-field">
                        <label>Harga (Rp)</label>
                        <input type="number" id="productPrice" required>
                    </div>
                </div>
                <div class="form-field">
                    <label>URL Gambar</label>
                    <input type="text" id="productImage" placeholder="assets/images/products/...">
                </div>
                <div class="form-field">
                    <label>Deskripsi</label>
                    <textarea id="productDesc" rows="3"></textarea>
                </div>
                <button type="submit" class="btn-save">Simpan Produk</button>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('.nav-btn[data-tab]').forEach(btn => {
            btn.addEventListener('click', () => {
                const tab = btn.getAttribute('data-tab');
                document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                document.querySelectorAll('.admin-tab').forEach(t => t.classList.remove('active'));
                document.getElementById(tab + 'Tab').classList.add('active');
            });
        });

        function openProductModal() {
            document.getElementById('modalTitle').innerText = 'Tambah Produk';
            document.getElementById('productForm').reset();
            document.getElementById('productId').value = '';
            document.getElementById('productModal').style.display = 'flex';
        }

        function editProduct(id) {
            fetch(`../admin-api-furni/get_product.php?id=${id}`)
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        document.getElementById('modalTitle').innerText = 'Edit Produk';
                        document.getElementById('productId').value = data.product.id;
                        document.getElementById('productName').value = data.product.name;
                        document.getElementById('productCategory').value = data.product.category || '';
                        document.getElementById('productPrice').value = data.product.price;
                        document.getElementById('productImage').value = data.product.image || '';
                        document.getElementById('productDesc').value = data.product.description || '';
                        document.getElementById('productModal').style.display = 'flex';
                    }
                });
        }

        function deleteProduct(id) {
            if(confirm('Yakin ingin menghapus produk ini?')) {
                fetch('../admin-api-furni/delete_product.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: id })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) location.reload();
                    else alert('Gagal: ' + data.message);
                });
            }
        }

        function updateStatus(select) {
            const orderId = select.getAttribute('data-id');
            const status = select.value;
            fetch('../admin-api-furni/update_order.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: orderId, status: status })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) alert('Status diupdate!');
                else alert('Gagal');
            });
        }

        function deleteOrder(id) {
            if(confirm('Yakin ingin menghapus pesanan ini?')) {
                fetch('../admin-api-furni/delete_order.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: id })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) location.reload();
                    else alert('Gagal: ' + data.message);
                });
            }
        }

        document.getElementById('productForm').addEventListener('submit', (e) => {
            e.preventDefault();
            const productData = {
                id: document.getElementById('productId').value || null,
                name: document.getElementById('productName').value,
                category: document.getElementById('productCategory').value,
                price: parseFloat(document.getElementById('productPrice').value),
                image: document.getElementById('productImage').value,
                description: document.getElementById('productDesc').value
            };
            fetch('../admin-api-furni/save_product.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(productData)
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) location.reload();
                else alert('Gagal: ' + data.message);
            });
        });

        function closeModal() {
            document.getElementById('productModal').style.display = 'none';
        }

        window.onclick = (e) => {
            if(e.target === document.getElementById('productModal')) closeModal();
        };
    </script>
</body>
</html>