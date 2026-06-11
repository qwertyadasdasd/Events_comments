@extends('layouts.app')

@section('title', 'Редактировать событие')

@section('content')
    <style>
        .edit-header {
            margin-bottom: 32px;
        }

        .edit-title {
            font-size: 28px;
            font-weight: 700;
            color: white;
            margin-bottom: 8px;
        }

        .edit-subtitle {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
        }

        .edit-card {
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.15);
        }

        .edit-card-body {
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

        .color-group {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .color-picker {
            width: 60px;
            height: 50px;
            padding: 5px;
            cursor: pointer;
        }

        .color-input {
            flex: 1;
        }

        @media (max-width: 768px) {
            .edit-card-body {
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

    <div class="edit-header">
        <h1 class="edit-title">Редактировать событие</h1>
        <p class="edit-subtitle">Измените информацию о мероприятии</p>
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

    <div class="edit-card">
        <div class="edit-card-body">
            <form action="{{ route('events.update', $event) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">
                        Название события
                        <span class="required">*</span>
                    </label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $event->name) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Описание</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $event->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Адрес</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address', $event->address) }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Местоположение</label>
                    <input type="text" name="location" class="form-control" value="{{ old('location', $event->location) }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Дата события</label>
                    <input type="datetime-local" name="start_date" class="form-control"
                           value="{{ old('start_date', $event->start_date ? date('Y-m-d\TH:i', strtotime($event->start_date)) : '') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Гости</label>
                    <input type="text" name="guests" class="form-control" value="{{ old('guests', $event->guests) }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Цвет события</label>
                    <div class="color-group">
                        <input type="color" name="color" class="color-picker form-control" value="{{ old('color', $event->color ?? '#667eea') }}">
                        <input type="text" id="colorHex" class="color-input form-control" value="{{ old('color', $event->color ?? '#667eea') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Порядок сортировки</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $event->sort_order ?? 0) }}">
                </div>

                <div class="form-actions">
                    <a href="{{ route('events.index') }}" class="btn-secondary">Назад</a>
                    <button type="submit" class="btn-primary">Сохранить изменения</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const colorPicker = document.querySelector('input[type="color"]');
        const colorHex = document.getElementById('colorHex');

        if (colorPicker && colorHex) {
            colorPicker.addEventListener('change', function() {
                colorHex.value = this.value;
            });

            colorHex.addEventListener('input', function() {
                colorPicker.value = this.value;
            });
        }
    </script>
@endsection
