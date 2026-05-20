<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f7fafc;
            min-height: 100vh;
        }

        .container {
            max-width: 72rem;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        .header {
            display: flex;
            justify-content: center;
            padding-top: 2rem;
        }

        .logo {
            height: 4rem;
            width: auto;
        }

        .card {
            background-color: white;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            margin-top: 2rem;
        }

        .card-grid {
            display: grid;
            grid-template-columns: 1fr;
        }

        .card-item {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .card-content {
            display: flex;
            align-items: center;
        }

        .card-icon {
            width: 2rem;
            height: 2rem;
            color: #a0aec0;
        }

        .card-title {
            margin-left: 1rem;
            font-size: 1.125rem;
            font-weight: 600;
        }

        .card-title a {
            color: #1a202c;
            text-decoration: underline;
        }

        .card-text {
            margin-top: 0.5rem;
            margin-left: 3rem;
            color: #718096;
            font-size: 0.875rem;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
            font-size: 0.875rem;
            color: #a0aec0;
        }

        .footer-links {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .footer-links a {
            color: #a0aec0;
            text-decoration: underline;
        }

        .login-links {
            position: fixed;
            top: 0;
            right: 0;
            padding: 1rem 1.5rem;
        }

        .login-links a {
            font-size: 0.875rem;
            color: #4a5568;
            text-decoration: underline;
            margin-left: 1rem;
        }

        @media (min-width: 768px) {
            .card-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .card-item {
                border-bottom: none;
            }

            .card-item:first-child {
                border-right: 1px solid #e2e8f0;
            }
        }

        @media (min-width: 640px) {
            .header {
                justify-content: flex-start;
                padding-top: 0;
            }

            .logo {
                height: 5rem;
            }

            .container {
                padding: 0 1.5rem;
            }
        }
    </style>
</head>
<body>
@if (Route::has('login'))
    <div class="login-links">
        @auth
            <a href="{{ url('/home') }}">Home</a>
        @else
            <a href="{{ route('login') }}">Log in</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}">Register</a>
            @endif
        @endauth
    </div>
@endif

<div class="container">
    <div class="header">
        <!-- Ваш SVG логотип здесь -->
        <div class="logo">Laravel</div>
    </div>

    <div class="card">
        <div class="card-grid">
            <div class="card-item">
                <div class="card-content">
                    <svg class="card-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <div class="card-title">
                        <a href="https://laravel.com/docs">Documentation</a>
                    </div>
                </div>
                <div class="card-text">
                    Laravel has wonderful, thorough documentation covering every aspect of the framework.
                </div>
            </div>

            <div class="card-item">
                <div class="card-content">
                    <svg class="card-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                        <path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <div class="card-title">
                        <a href="https://laracasts.com">Laracasts</a>
                    </div>
                </div>
                <div class="card-text">
                    Laracasts offers thousands of video tutorials on Laravel, PHP, and JavaScript development.
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="footer-links">
            <a href="https://laravel.bigcartel.com">Shop</a>
            <a href="https://github.com/sponsors/taylorotwell">Sponsor</a>
        </div>
        <div>
            Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
        </div>
    </div>
</div>
</body>
</html>
