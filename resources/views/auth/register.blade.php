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
            max-width: 480px;
            margin: 50px auto;
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
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

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-title {
            text-align: center;
            color: #333;
            font-size: 28px;
            margin-bottom: 5px;
        }

        .form-subtitle {
            text-align: center;
            color: #888;
            font-size: 14px;
            margin-bottom: 20px;
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
            font-size: 15px;
            transition: all 0.3s;
            outline: none;
        }

        .mb-3 input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .mb-3 input.error {
            border-color: #e74c3c;
        }

        .error-message {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
        }

        .btn-register {
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
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
            text-decoration: underline;
        }

        .password-strength {
            margin-top: 8px;
            height: 4px;
            background: #e0e0e0;
            border-radius: 2px;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: width 0.3s, background 0.3s;
        }

        .strength-text {
            font-size: 11px;
            margin-top: 5px;
            color: #888;
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
        <h2 class="form-title">📝 Регистрация</h2>
        <p class="form-subtitle">Создайте новый аккаунт</p>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Пожалуйста, исправьте следующие ошибки:</strong>
                <ul style="margin-top: 10px; margin-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}" id="registerForm">
            @csrf

            <div class="mb-3">
                <label>👤 Имя</label>
                <input type="text"
                       name="name"
                       placeholder="Введите ваше имя"
                       value="{{ old('name') }}"
                       class="@error('name') error @enderror"
                       required
                       minlength="2"
                       maxlength="255">
                @error('name')
                <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label>📧 Email</label>
                <input type="email"
                       name="email"
                       placeholder="Введите ваш email"
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
                       id="password"
                       placeholder="Придумайте пароль"
                       class="@error('password') error @enderror"
                       required
                       minlength="6">
                <div class="password-strength">
                    <div class="password-strength-bar" id="strengthBar"></div>
                </div>
                <div class="strength-text" id="strengthText"></div>
                @error('password')
                <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label>✅ Подтверждение пароля</label>
                <input type="password"
                       name="password_confirmation"
                       placeholder="Повторите пароль"
                       required>
            </div>

            <button type="submit" class="btn-register">Зарегистрироваться</button>
        </form>

        <div class="login-link">
            Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a>
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

                if (password.length >= 6) strength++;
                if (password.length >= 10) strength++;
                if (/[A-Z]/.test(password)) strength++;
                if (/[0-9]/.test(password)) strength++;
                if (/[^A-Za-z0-9]/.test(password)) strength++;

                const percentage = (strength / 5) * 100;
                strengthBar.style.width = percentage + '%';

                if (percentage < 20) {
                    strengthBar.style.background = '#e74c3c';
                    strengthText.textContent = 'Слабый пароль';
                    strengthText.style.color = '#e74c3c';
                } else if (percentage < 60) {
                    strengthBar.style.background = '#f39c12';
                    strengthText.textContent = 'Средний пароль';
                    strengthText.style.color = '#f39c12';
                } else {
                    strengthBar.style.background = '#27ae60';
                    strengthText.textContent = 'Сильный пароль';
                    strengthText.style.color = '#27ae60';
                }

                if (!password) {
                    strengthBar.style.width = '0%';
                    strengthText.textContent = '';
                }
            });
        }
    </script>
@endsection
