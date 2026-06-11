@extends('layouts.app')

@section('title', 'Запрос на роль')

@section('content')
    <style>
        .form-header {
            margin-bottom: 32px;
        }

        .form-title {
            font-size: 28px;
            font-weight: 700;
            color: white;
            margin-bottom: 8px;
        }

        .form-subtitle {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
        }

        .form-card {
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.15);
        }

        .form-card-body {
            padding: 40px;
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

        .form-label .required {
            color: #ef4444;
            margin-left: 4px;
        }

        .current-role {
            display: inline-block;
            padding: 8px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
        }

        .form-control, .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 14px;
            color: #1f2937;
            transition: all 0.2s ease;
            background: #f9fafb;
        }

        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: #667eea;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            margin-top: 32px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 28px;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -8px rgba(102, 126, 234, 0.5);
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #4b5563;
            padding: 12px 28px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
            display: inline-block;
            text-align: center;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
            transform: translateY(-1px);
        }

        .alert-success {
            background: #d1fae5;
            color: #059669;
            border-left: 4px solid #10b981;
            border-radius: 12px;
            padding: 14px 20px;
            margin-bottom: 24px;
        }

        .alert-danger {
            background: #fef2f2;
            color: #dc2626;
            border-left: 4px solid #ef4444;
            border-radius: 12px;
            padding: 14px 20px;
            margin-bottom: 24px;
        }

        .alert-warning {
            background: #fed7aa;
            color: #c2410c;
            border-left: 4px solid #f59e0b;
            border-radius: 12px;
            padding: 14px 20px;
            margin-bottom: 24px;
        }

        .error-message {
            color: #ef4444;
            font-size: 12px;
            margin-top: 6px;
            display: block;
        }

        @media (max-width: 768px) {
            .form-card-body {
                padding: 24px;
            }
            .form-actions {
                flex-direction: column;
            }
            .btn-primary, .btn-secondary {
                text-align: center;
            }
        }
    </style>

    <div class="form-header">
        <h1 class="form-title">Запрос на повышение роли</h1>
        <p class="form-subtitle">Повышение уровня доступа для расширения возможностей</p>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert-danger">{{ session('error') }}</div>
    @endif

    @if($hasPendingRequest ?? false)
        <div class="alert-warning">
            <strong>Внимание!</strong> У вас уже есть активный запрос на повышение роли. Дождитесь его обработки.
        </div>
    @endif

    <div class="form-card">
        <div class="form-card-body">
            <form action="{{ route('role-request.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Текущая роль</label>
                    <div>
                        <span class="current-role">{{ ucfirst(Auth::user()->role ?? 'Пользователь') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Желаемая роль
                        <span class="required">*</span>
                    </label>
                    <select name="requested_role" class="form-select" required>
                        <option value="">Выберите роль</option>
                        @foreach($availableRoles ?? ['admin', 'moderator', 'editor'] as $role)
                            <option value="{{ $role }}" {{ old('requested_role') == $role ? 'selected' : '' }}>
                                {{ ucfirst($role) }}
                            </option>
                        @endforeach
                    </select>
                    @error('requested_role')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Причина повышения
                        <span class="required">*</span>
                    </label>
                    <textarea name="reason"
                              class="form-control"
                              rows="5"
                              required
                              placeholder="Опишите, почему вы хотите получить эту роль...">{{ old('reason') }}</textarea>
                    @error('reason')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('dashboard') }}" class="btn-secondary">Назад</a>
                    <button type="submit" class="btn-primary">Отправить запрос</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('.form-control, .form-select').forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('is-invalid');
                const errorMsg = this.parentNode.querySelector('.error-message');
                if (errorMsg) {
                    errorMsg.remove();
                }
            });
        });
    </script>
@endsection
