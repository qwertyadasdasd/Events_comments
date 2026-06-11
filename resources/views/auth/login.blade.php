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

        body::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            pointer-events: none;
        }

        body::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            pointer-events: none;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        .login-card {
            max-width: 440px;
            width: 100%;
            background: #ffffff;
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .login-title {
            font-size: 32px;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 8px;
        }

        .login-subtitle {
            color: #6b7280;
            font-size: 14px;
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            color: #374151;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 15px;
            color: #1f2937;
            transition: all 0.2s ease;
            background: #f9fafb;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .form-input.error {
            border-color: #ef4444;
            background: #fef2f2;
        }

        .error-message {
            color: #ef4444;
            font-size: 12px;
            font-weight: 500;
            margin-top: 6px;
            display: block;
        }

        .login-button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 8px;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(102, 126, 234, 0.4);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .register-link {
            text-align: center;
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }

        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .register-link a:hover {
            color: #764ba2;
        }

        .alert {
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
        }

        .alert-danger {
            background: #fef2f2;
            color: #dc2626;
            border-left: 4px solid #dc2626;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 32px 24px;
            }
            .login-title {
                font-size: 28px;
            }
        }
    </style>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1 class="login-title">Добро пожаловать</h1>
                <p class="login-subtitle">Войдите в свой аккаунт</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" id="loginForm">
                @csrf

                <div class="form-group">
                    <label class="form-label">Электронная почта</label>
                    <input type="email"
                           name="email"
                           class="form-input @error('email') error @enderror"
                           placeholder="example@mail.ru"
                           value="{{ old('email') }}"
                           required>
                    @error('email')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Пароль</label>
                    <input type="password"
                           name="password"
                           class="form-input @error('password') error @enderror"
                           placeholder="Введите пароль"
                           required>
                    @error('password')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="login-button">Войти</button>
            </form>

            <div class="register-link">
                Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('loginForm')?.addEventListener('submit', function(e) {
            const email = document.querySelector('input[name="email"]');
            const password = document.querySelector('input[name="password"]');

            if (!email.value.trim()) {
                e.preventDefault();
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-message';
                errorDiv.textContent = 'Введите адрес электронной почты';
                email.parentNode.appendChild(errorDiv);
                email.classList.add('error');
                setTimeout(() => errorDiv.remove(), 3000);
                email.focus();
            } else if (!password.value) {
                e.preventDefault();
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-message';
                errorDiv.textContent = 'Введите пароль';
                password.parentNode.appendChild(errorDiv);
                password.classList.add('error');
                setTimeout(() => errorDiv.remove(), 3000);
                password.focus();
            }
        });

        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('error');
                const errorMsg = this.parentNode.querySelector('.error-message');
                if (errorMsg) errorMsg.remove();
            });
        });
    </script>
@endsection
