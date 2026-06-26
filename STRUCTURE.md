# Panduan Struktur Project FurniNest (Backend PHP/Laravel)

Dokumen ini dibuat untuk membantu Anda menjelaskan project ini kepada pengajar atau saat presentasi tugas.

## 1. Arsitektur Folder (MVC)
Project ini menggunakan pola **MVC (Model-View-Controller)** yang merupakan standar profesional:

- **Models (`app/Models/`)**: Tempat logika data dan hubungan database.
  - `Product.php`: Mengelola data furniture.
  - `User.php`: Mengelola data pengguna dan hak akses (Admin/User).
  - `CartItem.php`: Menangani barang di keranjang.
  
- **Views (`resources/views/`)**: Tempat tampilan (User Interface).
  - `pages/`: Halaman untuk pembeli (Home, Customizer, Checkout).
  - `admin/`: Dashboard khusus untuk pengelola toko.
  - `layouts/app.blade.php`: Template utama agar tampilan konsisten.

- **Controllers (`app/Http/Controllers/`)**: Otak dari aplikasi.
  - `Admin/`: Sub-folder baru agar kode manajemen admin terpisah dan rapi.
  - `Api/`: Menangani permintaan data cepat (seperti tambah ke keranjang tanpa refresh halaman).
  - `PageController.php`: Mengatur navigasi utama.

## 2. Fitur Unggulan & Penjelasan Teknis

### A. 3D Furniture Customizer (Three.js)
- **Lokasi**: `resources/views/pages/customize.blade.php`
- **Cara Kerja**: Menggunakan library Three.js untuk merender objek 3D di browser. Saat dimensi (p x l x t) diubah, kode JavaScript akan menghitung ulang volume dan mengupdate harga secara dinamis.

### B. Sistem Keranjang Cerdas (Selective Checkout)
- **Lokasi**: `CartController.php` & `script.js`
- **Cara Kerja**: Mendukung sinkronisasi antara `localStorage` (saat belum login) dan Database (saat sudah login). Saat checkout, hanya barang yang dipilih yang dihapus dari keranjang.

### C. Integrasi Pembayaran (DOKU Gateway)
- **Lokasi**: `DokuService.php` & `PaymentController.php`
- **Cara Kerja**: Mengirimkan data pesanan ke server DOKU, menerima respon URL pembayaran, dan melakukan verifikasi otomatis (Webhook/Callback) untuk mengubah status pesanan menjadi 'SUCCESS'.

### D. Manajemen Stok Otomatis
- **Cara Kerja**: Begitu pembayaran diverifikasi sukses, sistem akan mencari ID produk dalam pesanan dan mengurangi jumlah stok di database secara otomatis (`decrement`).

## 3. Cara Menjelaskan ke Penguji
"Project ini dibangun dengan **Laravel 10** dengan fokus pada pengalaman pengguna yang interaktif. Saya memisahkan logika **Admin** dan **User** agar lebih aman dan profesional. Fitur utamanya adalah kustomisasi furniture 3D yang terintegrasi langsung dengan sistem harga dan stok otomatis."

---
*Dibuat dengan ❤️ oleh Antigravity untuk membantu perjalanan belajar Backend Anda.*
