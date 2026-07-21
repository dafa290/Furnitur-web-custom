<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FurniNest | Masuk</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/pages/splash.css') }}">
</head>
<body>
    <div class="bg-image"></div>
    <div class="bg-overlay"></div>

    <div class="container">
        <div class="brand-side">
            <div class="brand-logo">
                <h1>FurniNest</h1>
                <div class="brand-tagline">Premium Furniture</div>
            </div>
            <div class="brand-quote">
                <h2>Temukan<br>Furniture Impian Anda</h2>
                <p>Koleksi eksklusif dengan desain timeless untuk ruang yang hangat dan penuh karakter.</p>
            </div>
            <div class="brand-features">
                <div class="feature-item"><i class="fas fa-check-circle"></i> <span>Garansi 5 Tahun</span></div>
                <div class="feature-item"><i class="fas fa-truck"></i> <span>Gratis Pengiriman Jakarta</span></div>
                <div class="feature-item"><i class="fas fa-star"></i> <span>4.9/5 dari 2000+ Pelanggan</span></div>
            </div>
        </div>

        <div class="form-side">
            <div class="form-header">
                <h3>Selamat Datang Kembali</h3>
                <p>Masuk untuk melanjutkan belanja Anda</p>
            </div>

            @if(isset($error))
                <div class="error-msg">{{ $error }}</div>
            @endif

            <form method="post" action="/login">
                @csrf
                <div class="form-group">
                    <label>Email</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="contoh@email.com" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Kata sandi" required>
                    </div>
                </div>
                <button type="submit" class="btn-login">Masuk</button>
            </form>

            <div class="divider">
                <span>atau</span>
            </div>

            <div class="btn-group">
                <a href="/register" class="btn-register">Buat Akun</a>
                <a href="/home" class="btn-skip">Jelajahi Dulu</a>
            </div>
        </div>
    </div>
</body>
</html>
