<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FurniNest</title>
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
            padding: 20px;
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
            max-width: 480px;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 40px;
            padding: 60px 50px;
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
            margin-bottom: 40px;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 42px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: -1px;
            margin-bottom: 4px;
        }

        .tagline {
            color: var(--gold);
            font-size: 12px;
            letter-spacing: 4px;
            text-transform: uppercase;
            font-weight: 700;
        }

        .auth-container h1 {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 35px;
            position: relative;
            display: inline-block;
        }

        .auth-container h1::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 2px;
            background: var(--gold);
        }

        .form-group {
            margin-bottom: 24px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--text-light);
            padding-left: 4px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gold);
            font-size: 16px;
            transition: all 0.3s;
        }

        .form-group input {
            width: 100%;
            padding: 16px 20px 16px 52px;
            background: #F9F7F5;
            border: 1.5px solid transparent;
            border-radius: 20px;
            font-family: 'Inter', sans-serif;
            font-size: 15px;
            color: var(--text-dark);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .form-group input:focus {
            outline: none;
            background: white;
            border-color: var(--gold);
            box-shadow: 0 10px 25px rgba(198, 161, 91, 0.1);
            transform: translateY(-2px);
        }

        .form-group input:focus + i {
            color: var(--brown);
        }

        .options-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-light);
            cursor: pointer;
        }

        .forgot-pw {
            color: var(--gold-dark);
            text-decoration: none;
            font-weight: 500;
        }

        .btn-login {
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
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            box-shadow: 0 15px 30px rgba(62, 39, 35, 0.2);
        }

        .btn-login:hover {
            background: var(--text-dark);
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(62, 39, 35, 0.3);
        }

        .btn-login i {
            font-size: 18px;
            transition: transform 0.3s;
        }

        .btn-login:hover i {
            transform: translateX(5px);
        }

        .error-msg {
            background: #FFF1F0;
            color: #D32F2F;
            padding: 15px 20px;
            border-radius: 15px;
            margin-bottom: 25px;
            font-size: 14px;
            text-align: left;
            border-left: 4px solid #D32F2F;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .auth-link {
            text-align: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid var(--border-light);
            color: var(--text-light);
            font-size: 15px;
        }

        .auth-link a {
            color: var(--brown);
            text-decoration: none;
            font-weight: 700;
            position: relative;
        }

        .auth-link a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1.5px;
            background: var(--gold);
            transition: width 0.3s;
        }

        .auth-link a:hover::after {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="logo-box">
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
</body>
</html>
