<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/pages/welcome.css') }}">

    </head>
    <body class="bg-light min-vh-100 d-flex flex-column justify-content-center align-items-center">
        <div class="container text-center py-5">
            <h1 class="display-3 fw-bold text-danger mb-4">Laravel Bootstrap</h1>
            <p class="lead text-secondary mb-5">FurniNest is running beautifully.</p>
            
            <div class="d-flex justify-content-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/home') }}" class="btn btn-outline-danger btn-lg px-4 rounded-pill">Enter Home</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-danger btn-lg px-5 rounded-pill shadow-sm">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg px-4 rounded-pill bg-white">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
            
            <div class="mt-5 pt-5 text-muted small">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
