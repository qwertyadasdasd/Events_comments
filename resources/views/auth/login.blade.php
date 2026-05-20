@extends('layouts.app')
@section('content')
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .card-body {
            max-width: 420px;
            margin: 60px auto;
            background: #fff;
            padding: 40px 35px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .form-title {
            text-align: center;
            color: #333;
            font-size: 26px;
            margin-bottom: 25px;
        }

        .mb-3 {
            margin-bottom: 18px;
        }

        .mb-3 label {
            display: block;
            color: #555;
            font-size: 13px;
            margin-bottom: 5px;
        }

        .mb-3 input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
            box-sizing: border-box;
        }

        .mb-3 input:focus {
            border-color: #667eea;
            outline: none;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-login:hover {
            opacity: 0.9;
            transform: scale(1.02);
        }

        .register-link {
            text-align: center;
            margin-top: 18px;
            font-size: 14px;
            color: #555;
        }

        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: bold;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>

    <div class="card-body">
        <h2 class="form-title">Вход</h2>

        <form method="POST" action="{{route('login.post')}}">
            @csrf

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" placeholder="Введите email" value="{{old('email')}}">
                @error('email')
                <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label>Пароль</label>
                <input type="password" name="password" placeholder="Введите пароль">
                @error('password')
                <span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-login">Войти</button>
        </form>

        <div class="register-link">
            Нет аккаунта? <a href="{{route('register')}}">Зарегистрироваться</a>
        </div>
    </div>
@endsection
