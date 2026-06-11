@extends('layouts.app')

@section('content')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
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

        .dashboard-container {
            max-width: 1280px;
            margin: 40px auto;
            padding: 0 24px;
            position: relative;
            z-index: 1;
        }

        /* Приветственная секция */
        .welcome-section {
            margin-bottom: 32px;
        }

        .welcome-title {
            font-size: 28px;
            font-weight: 700;
            color: white;
            margin-bottom: 8px;
        }

        .welcome-subtitle {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
        }

        /* Карточка профиля */
        .profile-card {
            background: #ffffff;
            border-radius: 28px;
            padding: 32px 36px;
            margin-bottom: 32px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 24px;
            transition: transform 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-2px);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .avatar {
            width: 88px;
            height: 88px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            font-weight: 600;
            color: white;
            text-transform: uppercase;
            box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.4);
        }

        .user-details h2 {
            margin: 0 0 6px 0;
            color: #1f2937;
            font-size: 26px;
            font-weight: 700;
        }

        .user-details p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
        }

        .role-badge {
            display: inline-block;
            padding: 6px 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 12px;
            letter-spacing: 0.3px;
        }

        /* Статистика */
        .stats {
            display: flex;
            gap: 48px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 34px;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .stat-label {
            font-size: 12px;
            color: #6b7280;
            margin-top: 6px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Сетка виджетов */
        .widgets-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 28px;
            margin-bottom: 32px;
        }

        .widget {
            background: #ffffff;
            border-radius: 24px;
            padding: 28px;
            box-shadow: 0 15px 35px -10px rgba(0, 0, 0, 0.1);
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .widget::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .widget:hover::before {
            transform: scaleX(1);
        }

        .widget:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 45px -12px rgba(0, 0, 0, 0.2);
        }

        .widget-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 2px solid #f3f4f6;
        }

        .widget-icon {
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 700;
            color: white;
        }

        .widget-title {
            font-size: 20px;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }

        .widget-subtitle {
            font-size: 13px;
            color: #9ca3af;
            margin: 4px 0 0 0;
        }

        .widget-text {
            color: #6b7280;
            margin-bottom: 24px;
            line-height: 1.6;
            font-size: 14px;
        }

        /* Кнопки */
        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 12px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 14px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-action:hover {
            transform: translateX(6px);
            box-shadow: 0 8px 20px -8px rgba(102, 126, 234, 0.5);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .btn-secondary:hover {
            box-shadow: 0 8px 20px -8px rgba(16, 185, 129, 0.5);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }

        .btn-danger:hover {
            box-shadow: 0 8px 20px -8px rgba(239, 68, 68, 0.5);
            transform: translateY(-2px);
        }

        /* Активность */
        .recent-activity {
            background: #ffffff;
            border-radius: 24px;
            padding: 28px;
            box-shadow: 0 15px 35px -10px rgba(0, 0, 0, 0.1);
        }

        .recent-title {
            font-size: 20px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 2px solid #f3f4f6;
        }

        .activity-list {
            margin-top: 8px;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 16px 0;
            border-bottom: 1px solid #f3f4f6;
            transition: background 0.2s ease;
        }

        .activity-item:hover {
            background: #f9fafb;
            margin: 0 -8px;
            padding: 16px 8px;
            border-radius: 12px;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-time {
            font-size: 12px;
            color: #9ca3af;
            min-width: 110px;
            font-weight: 500;
        }

        .activity-text {
            flex: 1;
            color: #4b5563;
            font-size: 14px;
        }

        .status-pending {
            color: #f59e0b;
            font-weight: 600;
        }

        .status-approved {
            color: #10b981;
            font-weight: 600;
        }

        .status-rejected {
            color: #ef4444;
            font-weight: 600;
        }

        /* Алерты */
        .alert {
            padding: 16px 24px;
            border-radius: 16px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
            backdrop-filter: blur(10px);
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
            border-left: 4px solid #10b981;
        }

        /* Выход */
        .logout-section {
            text-align: center;
            margin-top: 36px;
        }

        /* Адаптивность */
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 0 16px;
                margin: 24px auto;
            }

            .welcome-title {
                font-size: 24px;
            }

            .profile-card {
                flex-direction: column;
                text-align: center;
                padding: 28px 20px;
            }

            .user-info {
                flex-direction: column;
            }

            .stats {
                justify-content: center;
                gap: 32px;
            }

            .stat-number {
                font-size: 28px;
            }

            .widgets-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .activity-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .activity-time {
                min-width: auto;
            }
        }

        /* Анимация загрузки */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .profile-card, .widget, .recent-activity {
            animation: fadeIn 0.5s ease forwards;
        }

        .widget:nth-child(1) { animation-delay: 0.1s; }
        .widget:nth-child(2) { animation-delay: 0.2s; }
        .widget:nth-child(3) { animation-delay: 0.3s; }
        .recent-activity { animation-delay: 0.4s; }
    </style>

    <div class="dashboard-container">
        <div class="welcome-section">
            <h1 class="welcome-title">Панель управления</h1>
            <p class="welcome-subtitle">Добро пожаловать в вашу персональную панель</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="profile-card">
            <div class="user-info">
                <div class="avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                <div class="user-details">
                    <h2>{{ Auth::user()->name }}</h2>
                    <p>{{ Auth::user()->email }}</p>
                    <span class="role-badge">
                        @if(Auth::user()->role === 'admin') Администратор
                        @elseif(Auth::user()->role === 'moderator') Модератор
                        @else Пользователь
                        @endif
                    </span>
                </div>
            </div>
            <div class="stats">
                <div class="stat-item">
                    <div class="stat-number">{{ $commentsCount ?? 0 }}</div>
                    <div class="stat-label">Комментарии</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $eventsCount ?? 0 }}</div>
                    <div class="stat-label">События</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ round($daysRegistered ?? 1) }}</div>
                    <div class="stat-label">Дней с нами</div>
                </div>
            </div>
        </div>

        <div class="widgets-grid">
            <div class="widget">
                <div class="widget-header">
                    <div class="widget-icon">C</div>
                    <div>
                        <h3 class="widget-title">Комментарии</h3>
                        <p class="widget-subtitle">Управление отзывами</p>
                    </div>
                </div>
                <p class="widget-text">Просматривайте, модерируйте и отвечайте на комментарии пользователей.</p>
                <a href="{{ route('comments.index') }}" class="btn-action">
                    Перейти к комментариям
                    <span>→</span>
                </a>
            </div>

            <div class="widget">
                <div class="widget-header">
                    <div class="widget-icon">E</div>
                    <div>
                        <h3 class="widget-title">События</h3>
                        <p class="widget-subtitle">Календарь мероприятий</p>
                    </div>
                </div>
                <p class="widget-text">Создавайте, редактируйте и управляйте предстоящими событиями.</p>
                <a href="{{ route('events.index') }}" class="btn-action">
                    Управлять событиями
                    <span>→</span>
                </a>
            </div>

            <div class="widget">
                <div class="widget-header">
                    <div class="widget-icon">R</div>
                    <div>
                        <h3 class="widget-title">Запрос на роль</h3>
                        <p class="widget-subtitle">Повышение уровня доступа</p>
                    </div>
                </div>
                <p class="widget-text">Отправьте запрос на повышение роли для расширения возможностей.</p>
                <a href="{{ route('role-request.create') }}" class="btn-action btn-secondary">
                    Запросить роль
                    <span>→</span>
                </a>
            </div>
        </div>

        <div class="recent-activity">
            <h3 class="recent-title">История запросов</h3>
            <div class="activity-list">
                @forelse($myRoleRequests ?? [] as $request)
                    <div class="activity-item">
                        <div class="activity-time">{{ $request->created_at->diffForHumans() }}</div>
                        <div class="activity-text">
                            Запрос на роль <strong>{{ $request->requested_role }}</strong> —
                            @if($request->status === 'pending')
                                <span class="status-pending">на рассмотрении</span>
                            @elseif($request->status === 'approved')
                                <span class="status-approved">одобрен</span>
                            @else
                                <span class="status-rejected">отклонен</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="activity-item">
                        <div class="activity-text" style="color: #9ca3af;">У вас пока нет запросов на повышение роли</div>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="logout-section">
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-action btn-danger">
                    Выйти из аккаунта
                    <span>→</span>
                </button>
            </form>
        </div>
    </div>
@endsection
