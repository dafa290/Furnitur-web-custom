<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - FurniNest</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --cream: #FDFBF7;
            --warm-white: #FFFFFF;
            --brown: #3E2723;
            --brown-light: #5D4037;
            --gold: #D4AF37;
            --gold-light: #F1E5AC;
            --text-dark: #2C1B18;
            --text-light: #8D6E63;
            --border-light: #EFEBE9;
            --accent: #C6A15B;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #F5F0E8 0%, #E8DFD5 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
            overflow-x: hidden;
            position: relative;
        }

        /* Decorative Background Elements */
        body::before, body::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(198, 161, 91, 0.1) 0%, rgba(198, 161, 91, 0) 70%);
            z-index: -1;
        }
        body::before { top: -100px; right: -100px; }
        body::after { bottom: -100px; left: -100px; }

        .auth-container {
            max-width: 520px;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 40px;
            padding: 50px;
            box-shadow: 0 40px 100px rgba(62, 39, 35, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.8);
            text-align: center;
            animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo-box {
            margin-bottom: 30px;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: -1px;
            margin-bottom: 4px;
        }

        .tagline {
            color: var(--gold);
            font-size: 11px;
            letter-spacing: 4px;
            text-transform: uppercase;
            font-weight: 700;
        }

        .auth-container h1 {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 30px;
            position: relative;
            display: inline-block;
        }

        .auth-container h1::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 2px;
            background: var(--gold);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            text-align: left;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: var(--text-light);
            padding-left: 4px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gold);
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px 14px 48px;
            background: #F9F7F5;
            border: 1.5px solid transparent;
            border-radius: 16px;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            color: var(--text-dark);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .form-group input:focus {
            outline: none;
            background: white;
            border-color: var(--gold);
            box-shadow: 0 10px 20px rgba(198, 161, 91, 0.1);
        }

        .btn-register {
            width: 100%;
            padding: 18px;
            background: var(--brown);
            border: none;
            border-radius: 20px;
            color: white;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            margin-top: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            box-shadow: 0 15px 30px rgba(62, 39, 35, 0.2);
        }

        .btn-register:hover {
            background: var(--text-dark);
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(62, 39, 35, 0.3);
        }

        .error-msg {
            background: #FFF1F0;
            color: #D32F2F;
            padding: 12px 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 13px;
            text-align: left;
            border-left: 3px solid #D32F2F;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .auth-link {
            text-align: center;
            margin-top: 35px;
            padding-top: 25px;
            border-top: 1px solid var(--border-light);
            color: var(--text-light);
            font-size: 14px;
        }

        .auth-link a {
            color: var(--brown);
            text-decoration: none;
            font-weight: 700;
        }

        .footer-note {
            margin-top: 20px;
            font-size: 11px;
            color: var(--text-light);
            line-height: 1.5;
        }

        @media (max-width: 480px) {
            .form-grid { grid-template-columns: 1fr; }
            .form-group.full-width { grid-column: span 1; }
        }
    </style>
</head>
<body>
    <div class="auth-container">
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
