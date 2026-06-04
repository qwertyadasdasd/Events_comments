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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .card-body {
            max-width: 420px;
            margin: 60px auto;
            background: #fff;
            padding: 40px 35px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-title {
            text-align: center;
            color: #333;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .form-subtitle {
            text-align: center;
            color: #888;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .mb-3 {
            margin-bottom: 20px;
        }

        .mb-3 label {
            display: block;
            color: #555;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .mb-3 input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s;
            box-sizing: border-box;
        }

        .mb-3 input:focus {
            border-color: #667eea;
            outline: none;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .mb-3 input.error {
            border-color: #e74c3c;
        }

        .error-message {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .register-link {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
            color: #555;
        }

        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.2s;
        }

        .register-link a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-danger {
            background: #fee2e2;
            color: #e74c3c;
            border-left: 4px solid #e74c3c;
        }
    </style>

    <div class="card-body">
        <h2 class="form-title">🔐 Вход в систему</h2>
        <p class="form-subtitle">Добро пожаловать обратно!</p>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" id="loginForm">
            @csrf

            <div class="mb-3">
                <label>📧 Email</label>
                <input type="email"
                       name="email"
                       placeholder="Введите email"
                       value="{{ old('email') }}"
                       class="@error('email') error @enderror"
                       required>
                @error('email')
                <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label>🔒 Пароль</label>
                <input type="password"
                       name="password"
                       placeholder="Введите пароль"
                       class="@error('password') error @enderror"
                       required>
                @error('password')
                <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-login">Войти</button>
        </form>

        <div class="register-link">
            Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a>
        </div>
    </div>

    <script>
        document.getElementById('loginForm')?.addEventListener('submit', function(e) {
            const email = document.querySelector('input[name="email"]');
            const password = document.querySelector('input[name="password"]');

            if (!email.value.trim()) {
                e.preventDefault();
                alert('Введите email');
                email.focus();
            } else if (!password.value) {
                e.preventDefault();
                alert('Введите пароль');
                password.focus();
            }
        });
    </script>
@endsection
