@extends('layouts.app')

@section('content')
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .profile-card {
            background: #fff;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            font-weight: bold;
            color: white;
        }

        .user-details h2 {
            margin: 0 0 5px 0;
            color: #333;
            font-size: 24px;
        }

        .user-details p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }

        .role-badge {
            display: inline-block;
            padding: 4px 12px;
            background: #667eea;
            color: white;
            border-radius: 20px;
            font-size: 12px;
            margin-top: 8px;
        }

        .stats {
            display: flex;
            gap: 30px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 28px;
            font-weight: bold;
            color: #667eea;
        }

        .stat-label {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }

        .widgets-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .widget {
            background: #fff;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s;
        }

        .widget:hover {
            transform: translateY(-5px);
        }

        .widget-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .widget-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .widget-title {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            margin: 0;
        }

        .widget-subtitle {
            font-size: 13px;
            color: #888;
            margin: 0;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
            margin-top: 15px;
        }

        .btn-action:hover {
            background: #764ba2;
            transform: translateX(5px);
        }

        .btn-secondary {
            background: #48bb78;
        }

        .btn-secondary:hover {
            background: #38a169;
        }

        .btn-danger {
            background: #e74c3c;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        .recent-activity {
            background: #fff;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .activity-list {
            margin-top: 20px;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-time {
            font-size: 12px;
            color: #999;
            min-width: 80px;
        }

        .activity-text {
            flex: 1;
            color: #555;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            border-radius: 20px;
            padding: 30px;
            max-width: 500px;
            width: 90%;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .close {
            font-size: 28px;
            cursor: pointer;
            color: #999;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .alert {
            padding: 12px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        @media (max-width: 768px) {
            .profile-card {
                flex-direction: column;
                text-align: center;
            }
            .user-info {
                flex-direction: column;
            }
            .widgets-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="dashboard-container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="profile-card">
            <div class="user-info">
                <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div class="user-details">
                    <h2>{{ Auth::user()->name }}</h2>
                    <p>{{ Auth::user()->email }}</p>
                    <span class="role-badge">
                    @if(Auth::user()->role === 'admin') 👑 Администратор
                        @elseif(Auth::user()->role === 'moderator') 🛡️ Модератор
                        else 👤 Пользователь
                        @endif
                </span>
                </div>
            </div>
            <div class="stats">
                <div class="stat-item">
                    <div class="stat-number">{{ $commentsCount ?? 0 }}</div>
                    <div class="stat-label">Комментариев</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $eventsCount ?? 0 }}</div>
                    <div class="stat-label">Событий</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $daysRegistered ?? 0 }}</div>
                    <div class="stat-label">Дней с регистрации</div>
                </div>
            </div>
        </div>

        <div class="widgets-grid">
            <div class="widget">
                <div class="widget-header">
                    <div class="widget-icon">💬</div>
                    <div>
                        <h3 class="widget-title">Комментарии</h3>
                        <p class="widget-subtitle">Управление отзывами</p>
                    </div>
                </div>
                <p style="color: #666; margin-bottom: 20px;">Просматривайте и модерируйте комментарии пользователей.</p>
                <a href="{{ route('comments.index') }}" class="btn-action">📝 Перейти к комментариям →</a>
            </div>

            <div class="widget">
                <div class="widget-header">
                    <div class="widget-icon">📅</div>
                    <div>
                        <h3 class="widget-title">События</h3>
                        <p class="widget-subtitle">Календарь мероприятий</p>
                    </div>
                </div>
                <p style="color: #666; margin-bottom: 20px;">Создавайте и редактируйте предстоящие события.</p>
                <a href="{{ route('events.index') }}" class="btn-action">🎯 Управлять событиями →</a>
            </div>

            <div class="widget">
                <div class="widget-header">
                    <div class="widget-icon">📝</div>
                    <div>
                        <h3 class="widget-title">Запрос на роль</h3>
                        <p class="widget-subtitle">Повышение уровня доступа</p>
                    </div>
                </div>
                <p style="color: #666; margin-bottom: 20px;">Отправьте запрос на повышение роли администратора.</p>
                <a href="{{ route('role-request.create') }}" class="btn-action btn-secondary">⭐ Запросить роль →</a>
            </div>
        </div>

        <div class="recent-activity">
            <h3 style="margin-bottom: 20px;">📋 Мои запросы на роль</h3>
            <div class="activity-list">
                @forelse($myRoleRequests ?? [] as $request)
                    <div class="activity-item">
                        <div class="activity-time">{{ $request->created_at->diffForHumans() }}</div>
                        <div class="activity-text">
                            Запрос на роль <strong>{{ $request->requested_role }}</strong> -
                            @if($request->status === 'pending') ⏳ на рассмотрении
                            @elseif($request->status === 'approved') ✅ одобрен
                            @else ❌ отклонен
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="activity-item">
                        <div class="activity-text" style="color: #999;">У вас пока нет запросов на повышение роли</div>
                    </div>
                @endforelse
            </div>
        </div>

        <div style="text-align: center; margin-top: 30px;">
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-action btn-danger">🚪 Выйти из аккаунта</button>
            </form>
        </div>
    </div>

    <script>
        function openSettingsModal() {
            document.getElementById('settingsModal').style.display = 'flex';
        }
        function closeSettingsModal() {
            document.getElementById('settingsModal').style.display = 'none';
        }
    </script>
@endsection
