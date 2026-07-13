# Laporan Singkat — Arsitektur MVC & Database FurniNest

---

## 1. Apa itu MVC?

MVC adalah pola arsitektur perangkat lunak yang memisahkan aplikasi menjadi 3 lapisan:

| Lapisan | Fungsi | Contoh di Project Ini |
|---|---|---|
| **Model** | Mengelola data & logika database | `app/Models/Product.php` |
| **View** | Menampilkan antarmuka ke pengguna | `resources/views/admin/dashboard.blade.php` |
| **Controller** | Menjadi jembatan antara Model dan View | `app/Http/Controllers/AdminDashboardController.php` |

---

## 2. Alur Kerja Dashboard Admin (MVC)

```
Browser (Request URL: /admin/dashboard)
        ↓
    [ROUTES] routes/web.php
        ↓
    [CONTROLLER] AdminDashboardController.php
        - Memanggil Model untuk ambil data
        - $totalSales, $totalOrders, $totalProducts, $totalUsers
        - $recentOrders (5 pesanan terbaru)
        - $lowStockProducts (produk stok < 10)
        ↓
    [MODEL] OrderHistory.php, Product.php, User.php
        - Query ke database MySQL (tabel: order_histories, products, users)
        ↓
    [VIEW] resources/views/admin/dashboard.blade.php
        - Menampilkan data dalam tabel & kartu statistik
        ↓
Browser (Response: Halaman HTML Dashboard)
```

---

## 3. Penjelasan File MVC untuk Dashboard Admin

### [CONTROLLER] AdminDashboardController.php
**Lokasi:** `app/Http/Controllers/AdminDashboardController.php`

Fungsi: Mengambil semua data statistik dari database menggunakan Model,
lalu mengirimkannya ke View untuk ditampilkan.

```php
class AdminDashboardController extends Controller
{
    public function index()
    {
        // Ambil total penjualan (hanya order yang berhasil)
        $totalSales = OrderHistory::whereNotIn('status', ['PENDING','CANCELLED','FAILED'])
                                  ->sum('total_amount');

        // Ambil ringkasan statistik
        $totalOrders   = OrderHistory::count();
        $totalProducts = Product::count();
        $totalUsers    = User::where('role', 'USER')->count();

        // 5 pesanan terbaru & produk stok hampir habis
        $recentOrders      = OrderHistory::with('user')->orderBy('created_at','desc')->take(5)->get();
        $lowStockProducts  = Product::where('stock', '<', 10)->take(5)->get();

        // Kirim semua data ke View
        return view('admin.dashboard', compact(
            'totalSales','totalOrders','totalProducts',
            'totalUsers','recentOrders','lowStockProducts'
        ));
    }
}
```

---

### [MODEL] Product.php
**Lokasi:** `app/Models/Product.php`

Fungsi: Merepresentasikan tabel `products` di database. Laravel ORM (Eloquent)
memungkinkan query database ditulis seperti kode PHP biasa, bukan SQL manual.

---

### [VIEW] dashboard.blade.php
**Lokasi:** `resources/views/admin/dashboard.blade.php`

Fungsi: Menampilkan data yang dikirim Controller dalam bentuk kartu statistik
dan tabel pesanan terbaru. Menggunakan Blade Template Engine milik Laravel
(sintaks `{{ $variabel }}` untuk menampilkan data dari PHP).

---

## 4. Struktur Folder MVC (Relevan dengan Dashboard Admin)

```
web-copy-php/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AdminDashboardController.php  ← CONTROLLER
│   │       ├── AdminProductController.php
│   │       ├── AdminOrderController.php
│   │       └── AdminUserController.php
│   └── Models/
│       ├── Product.php        ← MODEL
│       ├── OrderHistory.php   ← MODEL
│       └── User.php           ← MODEL
│
├── resources/
│   └── views/
│       └── admin/
│           ├── dashboard.blade.php  ← VIEW (Dashboard)
│           ├── layout.blade.php     ← VIEW (Template Sidebar Admin)
│           ├── products/
│           ├── orders/
│           └── users/
│
└── routes/
    └── web.php  ← Mendefinisikan URL → Controller
```

---

## 5. Tabel Database yang Digunakan Dashboard Admin

| Tabel | Diakses Lewat Model | Kegunaan |
|---|---|---|
| `products` | `Product.php` | Data produk & stok |
| `order_histories` | `OrderHistory.php` | Data pesanan pelanggan |
| `users` | `User.php` | Data akun pelanggan |

---

*Laporan ini dibuat untuk keperluan tugas kuliah — FurniNest Laravel Project.*
