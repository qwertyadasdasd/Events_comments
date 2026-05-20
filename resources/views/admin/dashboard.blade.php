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

        .sidebar a:hover, .sidebar a.active {
            background: #e94560;
            color: #fff;
        }

        .main-content {
            flex: 1;
            padding: 40px;
            color: #fff;
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
        }

        .card {
            background: #16213e;
            padding: 25px;
            border-radius: 12px;
            flex: 1;
            min-width: 180px;
            text-align: center;
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
        }
    </style>

    <div class="admin-wrapper">
        <aside class="sidebar">
            <h2>Админ-панель</h2>
            <a href="{{ route('admin.dashboard') }}" class="active">Дашборд</a>
            <a href="{{ route('admin.role-requests.index') }}">Запросы ролей</a>
        </aside>

        <main class="main-content">
            <h1>Привет, {{ Auth::user()->name }}!</h1>
            <p class="subtitle">Вы вошли как <strong>администратор</strong></p>

            <div class="cards">
                <div class="card">
                    <h3>{{ \App\Models\User::count() }}</h3>
                    <p>Всего пользователей</p>
                </div>
                <div class="card">
                    <h3>{{ \App\Models\RoleRequest::where('status', 'pending')->count() }}</h3>
                    <p>Ожидают запросов</p>
                </div>
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
