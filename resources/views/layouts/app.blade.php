<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Мой сайт')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background: #2c3e50;
            padding: 15px 30px;
            color: white;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin-right: 20px;
        }
        .navbar a:hover {
            text-decoration: underline;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="navbar">
    <a href="/">Главная</a>
    @auth
        <a href="{{ route('dashboard') }}">Дашборд</a>
        <a href="{{ route('events.index') }}">События</a>
        <a href="{{ route('comments.index') }}">Комментарии</a>
        @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}">Админ-панель</a>
        @endif
        <form action="{{ route('logout') }}" method="POST" style="display: inline; float: right;">
            @csrf
            <button type="submit" style="background: none; border: none; color: white; cursor: pointer;">Выйти</button>
        </form>
    @else
        <a href="{{ route('login') }}" style="float: right;">Войти</a>
        <a href="{{ route('register') }}" style="float: right;">Регистрация</a>
    @endauth
</div>

<div class="container">
    @yield('content')
</div>
</body>
</html>
