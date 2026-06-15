@extends('layouts.app')

@section('content')
    <style>
        body {
            background: #1a1a2e;
            margin: 0;
            font-family: 'Inter', 'Segoe UI', sans-serif;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: #16213e;
            padding: 40px 24px;
            transition: all 0.3s;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 80px;
                padding: 40px 12px;
            }
            .sidebar h2, .sidebar a span {
                display: none;
            }
            .sidebar a {
                text-align: center;
                font-size: 20px;
                padding: 12px;
            }
        }

        .sidebar h2 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 40px;
            background: linear-gradient(135deg, #e94560, #ff6b6b);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            letter-spacing: -0.5px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #a0a0b0;
            text-decoration: none;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 8px;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .sidebar a:hover, .sidebar a.active {
            background: linear-gradient(135deg, #e94560, #ff6b6b);
            color: white;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 40px 48px;
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 24px;
            }
        }

        .main-content h1 {
            font-size: 32px;
            font-weight: 700;
            color: white;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #a0a0b0;
            margin-bottom: 32px;
            font-size: 14px;
        }

        .subtitle strong {
            color: #e94560;
        }

        /* Cards */
        .cards {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 40px;
        }

        .card {
            background: #16213e;
            padding: 28px 24px;
            border-radius: 20px;
            flex: 1;
            min-width: 180px;
            text-align: center;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .card h3 {
            font-size: 42px;
            font-weight: 800;
            background: linear-gradient(135deg, #e94560, #ff6b6b);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 8px;
        }

        .card p {
            color: #a0a0b0;
            font-size: 14px;
            font-weight: 500;
        }

        /* Recent Requests */
        .recent-requests {
            background: #16213e;
            border-radius: 20px;
            padding: 24px;
            margin-top: 8px;
        }

        .recent-requests h3 {
            font-size: 18px;
            font-weight: 600;
            color: white;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #2a2a4a;
        }

        .request-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 0;
            border-bottom: 1px solid #2a2a4a;
        }

        .request-item:last-child {
            border-bottom: none;
        }

        .request-user {
            font-weight: 600;
            color: white;
        }

        .request-role {
            color: #a0a0b0;
            font-size: 13px;
            margin-top: 4px;
        }

        .request-status {
            padding: 5px 14px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-pending {
            background: #f39c12;
            color: #fff;
        }

        .status-approved {
            background: #27ae60;
            color: #fff;
        }

        .status-rejected {
            background: #e74c3c;
            color: #fff;
        }

        /* Buttons */
        .logout-btn {
            margin-top: 40px;
        }

        .logout-btn button {
            background: linear-gradient(135deg, #e94560, #ff6b6b);
            border: none;
            color: white;
            padding: 12px 28px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .logout-btn button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(233, 69, 96, 0.4);
        }

        /* Alerts */
        .alert {
            padding: 14px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-weight: 500;
        }

        .alert-success {
            background: #27ae60;
            color: white;
        }

        .alert-error {
            background: #e74c3c;
            color: white;
        }
    </style>

    <div class="admin-wrapper">
        <aside class="sidebar">
            <h2>Панель администратора</h2>
            <a href="{{ route('admin.dashboard') }}" class="active">
                <span>Главная</span>
            </a>
            <a href="{{ route('admin.role-requests') }}">
                <span>Запросы ролей</span>
            </a>
        </aside>

        <main class="main-content">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            <h1>Добро пожаловать, {{ Auth::user()->name }}</h1>
            <p class="subtitle">Вы вошли как <strong>{{ Auth::user()->role === 'admin' ? 'Администратор' : 'Модератор' }}</strong></p>

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
                <h3>Последние запросы на повышение</h3>
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
                                {{ $request->current_role ?? 'Пользователь' }} → {{ $request->requested_role }}
                            </div>
                        </div>
                        <div>
                            <span class="request-status
                                @if($request->status === 'pending') status-pending
                                @elseif($request->status === 'approved') status-approved
                                @else status-rejected
                                @endif">
                                @if($request->status === 'pending') Ожидает
                                @elseif($request->status === 'approved') Одобрен
                                @else Отклонен
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
                    <button type="submit">Выйти</button>
                </form>
            </div>
        </main>
    </div>
@endsection
