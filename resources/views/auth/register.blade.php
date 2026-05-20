@extends('layouts.app')
@section('content')
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .card-body {
            max-width: 450px;
            margin: 50px auto;
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-title {
            text-align: center;
            color: #333;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .mb-3 {
            display: flex;
            flex-direction: column;
        }

        .mb-3 label {
            color: #555;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .mb-3 input {
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            transition: border-color 0.3s;
            outline: none;
        }

        .mb-3 input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .btn-register {
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-top: 10px;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>

    <div class="card-body">
        <h2 class="form-title">Регистрация</h2>

        <form method="POST" action="{{route('register.post')}}">
            @csrf

            <div class="mb-3">
                <label>Имя</label>
                <input type="text" name="name" placeholder="Введите ваше имя" value="{{old('name')}}">
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" placeholder="Введите ваш email" value="{{old('email')}}">
            </div>

            <div class="mb-3">
                <label>Пароль</label>
                <input type="password" name="password" placeholder="Придумайте пароль">
            </div>

            <div class="mb-3">
                <label>Подтверждение пароля</label>
                <input type="password" name="password_confirmation" placeholder="Повторите пароль">
            </div>

            <button type="submit" class="btn-register">Зарегистрироваться</button>
        </form>

        <div class="login-link">
            Уже есть аккаунт? <a href="{{route('login')}}">Войти</a>
        </div>
    </div>
@endsection
