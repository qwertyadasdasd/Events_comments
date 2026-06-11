<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Events</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Анимированные фоновые элементы */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.05)" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
            opacity: 0.3;
            pointer-events: none;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 2rem 2rem;
            position: relative;
            z-index: 1;
        }

        /* Новая шапка */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            margin-bottom: 3rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            font-size: 32px;
            color: white;
        }

        .logo-text {
            font-size: 28px;
            font-weight: 800;
            color: white;
            letter-spacing: -0.5px;
        }

        .logo-text span {
            background: linear-gradient(135deg, #FFD700, #FFA500);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .nav-buttons {
            display: flex;
            gap: 15px;
        }

        .btn {
            padding: 10px 24px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 14px;
        }

        .btn-login {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn-login:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .btn-register {
            background: white;
            color: #667eea;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-dashboard {
            background: linear-gradient(135deg, #FFD700, #FFA500);
            color: #333;
        }

        /* Hero секция */
        .hero {
            text-align: center;
            margin: 4rem 0;
        }

        .hero-title {
            font-size: 56px;
            font-weight: 800;
            color: white;
            margin-bottom: 20px;
            letter-spacing: -1px;
            animation: fadeInUp 0.8s ease;
        }

        .hero-subtitle {
            font-size: 20px;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 30px;
            animation: fadeInUp 0.8s ease 0.1s both;
        }

        /* Карточки */
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 3rem;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: fadeInUp 0.8s ease 0.2s both;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.4);
        }

        .feature-icon {
            font-size: 48px;
            color: white;
            margin-bottom: 20px;
        }

        .feature-title {
            font-size: 24px;
            font-weight: 700;
            color: white;
            margin-bottom: 15px;
        }

        .feature-text {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6;
        }

        /* Статистика */
        .stats {
            display: flex;
            justify-content: center;
            gap: 60px;
            margin-top: 4rem;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            backdrop-filter: blur(10px);
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 36px;
            font-weight: 800;
            color: white;
        }

        .stat-label {
            color: rgba(255, 255, 255, 0.8);
            margin-top: 5px;
        }

        /* Анимации */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Адаптивность */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 20px;
                padding: 1.5rem;
            }

            .hero-title {
                font-size: 36px;
            }

            .stats {
                flex-direction: column;
                gap: 20px;
            }

            .features {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <nav class="navbar">
        <div class="logo-section">
            <i class="fas fa-calendar-alt logo-icon"></i>
            <div class="logo-text">
                Event<span>Hub</span>
            </div>
        </div>

        @if (Route::has('login'))
            <div class="nav-buttons">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-dashboard">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-login">
                        <i class="fas fa-sign-in-alt"></i> Войти
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-register">
                            <i class="fas fa-user-plus"></i> Регистрация
                        </a>
                    @endif
                @endauth
            </div>
        @endif
    </nav>

    <div class="hero">
        <h1 class="hero-title">
            Управляйте событиями<br>с легкостью
        </h1>
        <p class="hero-subtitle">
            Современная платформа для создания и управления мероприятиями
        </p>
    </div>

    <div class="features">
        <div class="feature-card">
            <i class="fas fa-plus-circle feature-icon"></i>
            <h3 class="feature-title">Создавайте события</h3>
            <p class="feature-text">Легко добавляйте новые мероприятия с подробным описанием, датой и местом проведения</p>
        </div>

        <div class="feature-card">
            <i class="fas fa-users feature-icon"></i>
            <h3 class="feature-title">Приглашайте гостей</h3>
            <p class="feature-text">Управляйте списком гостей и отслеживайте подтверждения участия</p>
        </div>

        <div class="feature-card">
            <i class="fas fa-chart-line feature-icon"></i>
            <h3 class="feature-title">Анализируйте</h3>
            <p class="feature-text">Получайте статистику посещаемости и отзывы о мероприятиях</p>
        </div>
    </div>


</div>
</body>
</html>
