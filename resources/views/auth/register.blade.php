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

        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        .register-card {
            max-width: 480px;
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

        .register-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .register-title {
            font-size: 32px;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 8px;
        }

        .register-subtitle {
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

        .password-strength {
            margin-top: 8px;
            height: 4px;
            background: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: width 0.3s ease, background 0.3s ease;
        }

        .strength-text {
            font-size: 11px;
            margin-top: 6px;
            font-weight: 500;
        }

        .register-button {
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

        .register-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(102, 126, 234, 0.4);
        }

        .register-button:active {
            transform: translateY(0);
        }

        .login-link {
            text-align: center;
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .login-link a:hover {
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

        .alert-danger ul {
            margin-top: 8px;
            margin-left: 20px;
        }

        @media (max-width: 480px) {
            .register-card {
                padding: 32px 24px;
            }
            .register-title {
                font-size: 28px;
            }
        }
    </style>

    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <h1 class="register-title">Создать аккаунт</h1>
                <p class="register-subtitle">Зарегистрируйтесь, чтобы начать работу</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Пожалуйста, исправьте следующие ошибки:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}" id="registerForm">
                @csrf

                <div class="form-group">
                    <label class="form-label">Имя пользователя</label>
                    <input type="text"
                           name="name"
                           class="form-input @error('name') error @enderror"
                           placeholder="Введите ваше имя"
                           value="{{ old('name') }}"
                           required>
                    @error('name')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

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
                           id="password"
                           class="form-input @error('password') error @enderror"
                           placeholder="Придумайте пароль"
                           required>
                    <div class="password-strength">
                        <div class="password-strength-bar" id="strengthBar"></div>
                    </div>
                    <div class="strength-text" id="strengthText"></div>
                    @error('password')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Подтверждение пароля</label>
                    <input type="password"
                           name="password_confirmation"
                           class="form-input"
                           placeholder="Повторите пароль"
                           required>
                </div>

                <button type="submit" class="register-button">Зарегистрироваться</button>
            </form>

            <div class="login-link">
                Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a>
            </div>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');

        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;
                let percentage = 0;
                let message = '';
                let color = '';

                if (password.length === 0) {
                    strengthBar.style.width = '0%';
                    strengthText.textContent = '';
                    return;
                }

                if (password.length >= 6) strength++;
                if (password.length >= 10) strength++;
                if (/[A-ZА-Я]/.test(password)) strength++;
                if (/[0-9]/.test(password)) strength++;
                if (/[^A-Za-zА-Яа-я0-9]/.test(password)) strength++;

                percentage = (strength / 5) * 100;

                if (percentage < 20) {
                    message = 'Слабый пароль';
                    color = '#ef4444';
                } else if (percentage < 60) {
                    message = 'Средний пароль';
                    color = '#f59e0b';
                } else {
                    message = 'Сильный пароль';
                    color = '#10b981';
                }

                strengthBar.style.width = percentage + '%';
                strengthBar.style.background = color;
                strengthText.textContent = message;
                strengthText.style.color = color;
            });
        }

        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('error');
                const errorMsg = this.parentNode.querySelector('.error-message');
                if (errorMsg && !this.name.includes('password')) {
                    errorMsg.remove();
                }
            });
        });
    </script>
@endsection
