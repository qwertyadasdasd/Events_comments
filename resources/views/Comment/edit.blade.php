@extends('layouts.app')

@section('title', 'Редактировать комментарий')

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

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 14px;
            color: #1f2937;
            transition: all 0.2s ease;
            background: #f9fafb;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        textarea.form-control {
            resize: vertical;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .checkbox-group input {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .checkbox-group label {
            margin: 0;
            cursor: pointer;
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
        }

        .btn-secondary:hover {
            background: #e5e7eb;
            transform: translateY(-1px);
        }

        .alert-danger {
            background: #fef2f2;
            border-left: 4px solid #ef4444;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 24px;
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
        <h1 class="form-title">Редактировать комментарий</h1>
        <p class="form-subtitle">Комментарий #{{ $comment->id }}</p>
    </div>

    @if ($errors->any())
        <div class="alert-danger">
            <strong>Исправьте следующие ошибки:</strong>
            <ul style="margin-top: 8px; margin-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">
        <div class="form-card-body">
            <form action="{{ route('comments.update', $comment) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">
                        Имя
                        <span class="required">*</span>
                    </label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $comment->name) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Email
                        <span class="required">*</span>
                    </label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $comment->email) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Комментарий
                        <span class="required">*</span>
                    </label>
                    <textarea name="comment" class="form-control" rows="5" required>{{ old('comment', $comment->comment) }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">ID поста</label>
                    <input type="number" name="post_id" class="form-control" value="{{ old('post_id', $comment->post_id) }}">
                </div>

                <div class="form-group checkbox-group">
                    <input type="checkbox" name="approved" value="1" {{ old('approved', $comment->approved) ? 'checked' : '' }} id="approved">
                    <label for="approved">Одобрен</label>
                </div>

                <div class="form-actions">
                    <a href="{{ route('comments.index') }}" class="btn-secondary">Назад</a>
                    <button type="submit" class="btn-primary">Обновить</button>
                </div>

                <div class="form-group checkbox-group">
                    <input type="checkbox" name="is_public" value="1" id="is_public" {{ old('is_public', $comment->is_public ?? true) ? 'checked' : '' }}>
                    <label for="is_public">Публичный комментарий</label>
                </div>
            </form>
        </div>
    </div>
@endsection
