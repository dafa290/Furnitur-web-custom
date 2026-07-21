<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - FurniNest</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/pages/auth.css') }}">
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 py-4">
    <div class="auth-container register shadow-lg">
        <div class="logo-box text-center">
            <div class="logo">FurniNest</div>
            <div class="tagline">Artisanal & Timeless</div>
        </div>
        
        <h1>Create Account</h1>

        @if($errors->any())
            <div class="error-msg">
                <i class="fas fa-exclamation-circle"></i> 
                <span>{{ $errors->first() }}</span>
            </div>
        @endif
        
        <form method="post" action="/register">
            @csrf
            <div class="row g-3 text-start">
                <div class="col-12">
                    <div class="form-group mb-0">
                        <label>Full Name</label>
                        <div class="input-wrapper">
                            <input type="text" name="name" required placeholder="John Doe" value="{{ old('name') }}">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group mb-0">
                        <label>Email Address</label>
                        <div class="input-wrapper">
                            <input type="email" name="email" required placeholder="john@example.com" value="{{ old('email') }}">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-0">
                        <label>Password</label>
                        <div class="input-wrapper">
                            <input type="password" name="password" required placeholder="••••••••">
                            <i class="fas fa-lock"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-0">
                        <label>Phone Number</label>
                        <div class="input-wrapper">
                            <input type="tel" name="phone" placeholder="0812..." value="{{ old('phone') }}">
                            <i class="fas fa-phone"></i>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-register">
                <span>Join Now</span>
                <i class="fas fa-arrow-right"></i>
            </button>
        </form>
        
        <div class="auth-link">
            Already have an account? <a href="/login">Sign In here</a>
        </div>
        
        <div class="footer-note">
            By creating an account, you agree to our <a href="#" style="color: var(--brown); font-weight: 600;">Terms</a> and <a href="#" style="color: var(--brown); font-weight: 600;">Privacy Policy</a>.
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmxc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
