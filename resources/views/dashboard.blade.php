@extends('layouts.app')
@section('content')
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
        }

        .dashboard-container {
            max-width: 600px;
            margin: 80px auto;
            background: #fff;
            padding: 50px 40px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .dashboard-container h1 {
            color: #333;
            font-size: 30px;
            margin-bottom: 10px;
        }

        .dashboard-container p {
            color: #666;
            font-size: 16px;
            margin-bottom: 30px;
        }

        .btn-logout {
            padding: 12px 30px;
            background: #e74c3c;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-logout:hover {
            background: #764ba2;
        }
    </style>

    <div class="dashboard-container">
        <h1> Добро пожаловать, {{ Auth::user()->name }}!</h1>
        <p>Вы успешно вошли в систему.</p>

        <div class="btn-group">
            <a href="{{ route('comments.index') }}" class="btn-comment">Комментарии</a>
            <a href="{{ route('events.index') }}" class="btn-category">События</a>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">Выйти</button>
        </form>
    </div>
@endsection
