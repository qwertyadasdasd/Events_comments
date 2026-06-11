@extends('layouts.app')

@section('content')
    <style>
        body {
            background: #1a1a2e;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background: #16213e;
            color: #fff;
            padding: 30px 20px;
            transition: all 0.3s;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 80px;
                padding: 30px 10px;
            }

            .sidebar h2, .sidebar a span {
                display: none;
            }

            .sidebar a {
                text-align: center;
                font-size: 20px;
                padding: 10px;
            }
        }

        .sidebar h2 {
            font-size: 20px;
            margin-bottom: 30px;
            color: #e94560;
        }

        .sidebar a {
            display: block;
            color: #a0a0b0;
            text-decoration: none;
            padding: 10px 12px;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: 0.2s;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        .sidebar a:hover, .sidebar a.active {
            background: #e94560;
            color: #fff;
        }

        .main-content {
            flex: 1;
            padding: 40px;
            color: #fff;
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 20px;
            }
        }

        .main-content h1 {
            font-size: 28px;
            margin-bottom: 5px;
        }

        .main-content .subtitle {
            color: #a0a0b0;
            margin-bottom: 30px;
        }

        .cards {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .card {
            background: #16213e;
            padding: 25px;
            border-radius: 12px;
            flex: 1;
            min-width: 180px;
            text-align: center;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            font-size: 36px;
            color: #e94560;
            margin-bottom: 5px;
        }

        .card p {
            color: #a0a0b0;
            font-size: 14px;
        }

        .recent-requests {
            background: #16213e;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
        }

        .recent-requests h3 {
            margin-bottom: 20px;
            color: #e94560;
        }

        .request-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #2a2a4a;
        }

        .request-item:last-child {
            border-bottom: none;
        }

        .request-user {
            font-weight: bold;
        }

        .request-role {
            color: #a0a0b0;
            font-size: 14px;
        }

        .request-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            background: #f39c12;
            color: #fff;
        }

        .logout-btn {
            margin-top: 30px;
        }

        .logout-btn button {
            background: #e94560;
            border: none;
            color: #fff;
            padding: 12px 28px;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .logout-btn button:hover {
            opacity: 0.9;
        }

        .alert {
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #27ae60;
            color: #fff;
        }

        .alert-error {
            background: #e74c3c;
            color: #fff;
        }
    </style>

    <div class="admin-wrapper">
        <aside class="sidebar">
            <h2>🔧 Админ-панель</h2>
            <a href="{{ route('admin.dashboard') }}" class="active">
                <span>📊 Дашборд</span>
            </a>
            <a href="{{ route('admin.role-requests.index') }}">
                <span>📝 Запросы ролей</span>
            </a>
        </aside>

        <main class="main-content">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            <h1>Привет, {{ Auth::user()->name }}! 👋</h1>
            <p class="subtitle">Вы вошли как <strong>{{ Auth::user()->role === 'admin' ? 'администратор' : 'модератор' }}</strong></p>

            <div class="cards">
                <div class="card">
                    <h3>{{ \App\Models\User::count() }}</h3>
                    <p>Всего пользователей</p>
                </div>
                <div class="card">
                    <h3>{{ \App\Models\RoleRequest::where('status', 'pending')->count() }}</h3>
                    <p>Ожидают запросов</p>
                </div>
                <div class="card">
                    <h3>{{ \App\Models\RoleRequest::where('status', 'approved')->count() }}</h3>
                    <p>Одобрено запросов</p>
                </div>
            </div>

            <div class="recent-requests">
                <h3>📋 Последние запросы на повышение</h3>
                @php
                    $recentRequests = \App\Models\RoleRequest::with('user')
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();
                @endphp

                @forelse($recentRequests as $request)
                    <div class="request-item">
                        <div>
                            <div class="request-user">{{ $request->user->name }}</div>
                            <div class="request-role">
                                {{ $request->current_role }} → {{ $request->requested_role }}
                            </div>
                        </div>
                        <div>
                            <span class="request-status">
                                @if($request->status === 'pending') ⏳ Ожидает
                                @elseif($request->status === 'approved') ✅ Одобрен
                                @else ❌ Отклонен
                                @endif
                            </span>
                        </div>
                    </div>
                @empty
                    <p style="color: #a0a0b0;">Нет запросов на повышение</p>
                @endforelse
            </div>

            <div class="logout-btn">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">🚪 Выйти</button>
                </form>
            </div>
        </main>
    </div>
@endsection
