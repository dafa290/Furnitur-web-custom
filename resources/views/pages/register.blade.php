<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - FurniNest</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/pages/auth.css') }}">
</head>
<body>
    <div class="auth-container register">
        <div class="logo-box">
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
            <div class="form-grid">
                <div class="form-group full-width">
                    <label>Full Name</label>
                    <div class="input-wrapper">
                        <input type="text" name="name" required placeholder="John Doe" value="{{ old('name') }}">
                        <i class="fas fa-user"></i>
                    </div>
                </div>

                <div class="form-group full-width">
                    <label>Email Address</label>
                    <div class="input-wrapper">
                        <input type="email" name="email" required placeholder="john@example.com" value="{{ old('email') }}">
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-wrapper">
                        <input type="password" name="password" required placeholder="••••••••">
                        <i class="fas fa-lock"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <div class="input-wrapper">
                        <input type="tel" name="phone" placeholder="0812..." value="{{ old('phone') }}">
                        <i class="fas fa-phone"></i>
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
</body>
</html>
