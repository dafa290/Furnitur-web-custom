<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FurniNest | Masuk</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/pages/splash.css') }}">
</head>
<body>
    <div class="bg-image"></div>
    <div class="bg-overlay"></div>

    <div class="container min-vh-100 d-flex align-items-center position-relative z-2 py-5">
        <div class="row w-100 align-items-center justify-content-between gy-5">
            <div class="col-lg-6 text-center text-lg-start brand-side">
                <div class="brand-logo">
                    <h1>FurniNest</h1>
                    <div class="brand-tagline">Premium Furniture</div>
                </div>
                <div class="brand-quote">
                    <h2>Temukan<br>Furniture Impian Anda</h2>
                    <p class="mx-auto mx-lg-0">Koleksi eksklusif dengan desain timeless untuk ruang yang hangat dan penuh karakter.</p>
                </div>
                <div class="brand-features d-flex flex-column gap-3 mt-4 align-items-center align-items-lg-start">
                    <div class="feature-item d-flex align-items-center gap-2"><i class="fas fa-check-circle"></i> <span>Garansi 5 Tahun</span></div>
                    <div class="feature-item d-flex align-items-center gap-2"><i class="fas fa-truck"></i> <span>Gratis Pengiriman Jakarta</span></div>
                    <div class="feature-item d-flex align-items-center gap-2"><i class="fas fa-star"></i> <span>4.9/5 dari 2000+ Pelanggan</span></div>
                </div>
            </div>

            <div class="col-lg-5 col-md-8 mx-auto mx-lg-0">
                <div class="form-side">
                    <div class="form-header text-center mb-4">
                        <h3>Selamat Datang Kembali</h3>
                        <p>Masuk untuk melanjutkan belanja Anda</p>
                    </div>

                    @if(isset($error))
                        <div class="error-msg text-center mb-4">{{ $error }}</div>
                    @endif

                    <form method="post" action="/login">
                        @csrf
                        <div class="form-group mb-4">
                            <label class="form-label d-block mb-2">Email</label>
                            <div class="input-wrapper position-relative">
                                <i class="fas fa-envelope"></i>
                                <input type="email" name="email" class="form-control" placeholder="contoh@email.com" required>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label class="form-label d-block mb-2">Password</label>
                            <div class="input-wrapper position-relative">
                                <i class="fas fa-lock"></i>
                                <input type="password" name="password" class="form-control" placeholder="Kata sandi" required>
                            </div>
                        </div>
                        <button type="submit" class="btn-login w-100">Masuk</button>
                    </form>

                    <div class="divider d-flex align-items-center gap-3 mb-4">
                        <span>atau</span>
                    </div>

                    <div class="btn-group w-100 d-flex gap-3">
                        <a href="/register" class="btn-register w-50 text-center">Buat Akun</a>
                        <a href="/home" class="btn-skip w-50 text-center">Jelajahi Dulu</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
