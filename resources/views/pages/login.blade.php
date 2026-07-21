<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FurniNest</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/pages/auth.css') }}">
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 py-4">
    <div class="auth-container shadow-lg">
        <div class="logo-box text-center">
            <div class="logo">FurniNest</div>
            <div class="tagline">Artisanal & Timeless</div>
        </div>
        
        <h1>Welcome Back</h1>

        @if(session('error') || isset($error))
            <div class="error-msg">
                <i class="fas fa-exclamation-circle"></i> 
                <span>{{ session('error') ?? $error }}</span>
            </div>
        @endif

        @if(session('status'))
            <div class="success-msg" style="background: #F6FFED; color: #52C41A; padding: 15px; border-radius: 15px; margin-bottom: 25px; border-left: 4px solid #52C41A; text-align: left; font-size: 14px;">
                <i class="fas fa-check-circle"></i> {{ session('status') }}
            </div>
        @endif

        <form method="post" action="/login">
            @csrf
            <div class="form-group">
                <label>Email Address</label>
                <div class="input-wrapper">
                    <input type="email" name="email" required placeholder="name@example.com">
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

            <div class="options-row">
                <label class="remember-me">
                    <input type="checkbox" name="remember"> Remember me
                </label>
                <a href="#" class="forgot-pw">Forgot Password?</a>
            </div>

            <button type="submit" class="btn-login">
                <span>Sign In</span>
                <i class="fas fa-arrow-right"></i>
            </button>
        </form>

        <div class="auth-link">
            Don't have an account? <a href="/register">Create one now</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmxc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
