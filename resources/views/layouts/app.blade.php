<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EventHub')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            position: relative;
        }

        /* Декоративные элементы фона */
        body::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -15%;
            width: 600px;
            height: 600px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            pointer-events: none;
        }

        body::after {
            content: '';
            position: absolute;
            bottom: -25%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            pointer-events: none;
        }

        /* Навбар */
        .navbar {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            padding: 16px 32px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-container {
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: 800;
            background: linear-gradient(135deg, #fff, #e0e0e0);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-decoration: none;
            letter-spacing: -0.5px;
        }

        .navbar-brand:hover {
            background: linear-gradient(135deg, #FFD700, #FFA500);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 24px;
            flex-wrap: wrap;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.2s ease;
            padding: 8px 0;
        }

        .nav-link:hover {
            color: white;
            transform: translateY(-1px);
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.15);
            border: none;
            color: white;
            cursor: pointer;
            padding: 8px 20px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-1px);
        }

        /* Контейнер */
        .main-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 32px 24px;
            position: relative;
            z-index: 1;
        }

        /* Адаптивность */
        @media (max-width: 768px) {
            .navbar-container {
                flex-direction: column;
                text-align: center;
            }

            .nav-links {
                justify-content: center;
            }

            .main-container {
                padding: 20px 16px;
            }
        }

        /* Анимация страниц */
        .page-content {
            animation: fadeInPage 0.4s ease forwards;
        }

        @keyframes fadeInPage {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    @stack('styles')
</head>
<body>
<nav class="navbar">
    <div class="navbar-container">
        <a href="{{ url('/') }}" class="navbar-brand">EventHub</a>

        <div class="nav-links">
            <a href="{{ url('/') }}" class="nav-link">Главная</a>

            @auth
                <a href="{{ route('dashboard') }}" class="nav-link">Дашборд</a>
                <a href="{{ route('events.index') }}" class="nav-link">События</a>
                <a href="{{ route('comments.index') }}" class="nav-link">Комментарии</a>

                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">Админ-панель</a>
                @endif

                <form action="{{ route('logout') }}" method="POST" style="display: inline; margin: 0;">
                    @csrf
                    <button type="submit" class="logout-btn">Выйти</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="nav-link">Войти</a>
                <a href="{{ route('register') }}" class="nav-link">Регистрация</a>
            @endauth
        </div>
    </div>
</nav>

<div class="main-container page-content">
    @yield('content')
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')
</body>
</html>
