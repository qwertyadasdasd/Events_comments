<!DOCTYPE html>
<html>
<head>
    <title>Создать событие</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 50px 0;
        }
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            text-align: center;
        }
        .card-header h2 {
            margin: 0;
            font-weight: 600;
        }
        .card-body {
            padding: 40px;
        }
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        .form-control {
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            padding: 12px 15px;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            transition: transform 0.3s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .btn-secondary {
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
        }
        .alert {
            border-radius: 10px;
            border-left: 5px solid #dc3545;
        }
        .required:after {
            content: "*";
            color: red;
            margin-left: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-calendar-plus"></i> Создать событие</h2>
                    <p class="mb-0 mt-2">Заполните информацию о событии</p>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Пожалуйста, исправьте следующие ошибки:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('events.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label required">Название события</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" required placeholder="Введите название события">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Описание</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                      rows="4" placeholder="Подробное описание события">{{ old('description') }}</textarea>
                            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Адрес</label>
                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                                   value="{{ old('address') }}" placeholder="Улица, дом, город">
                            @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Местоположение</label>
                            <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                                   value="{{ old('location') }}" placeholder="Название места проведения">
                            @error('location') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Дата события</label>
                            <input type="datetime-local" name="start_date" class="form-control @error('start_date') is-invalid @enderror"
                                   value="{{ old('start_date') }}">
                            <small class="text-muted">Формат: ГГГГ-ММ-ДД ЧЧ:ММ</small>
                            @error('start_date') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Гости</label>
                            <input type="text" name="guests" class="form-control @error('guests') is-invalid @enderror"
                                   value="{{ old('guests') }}" placeholder="Имена гостей через запятую">
                            @error('guests') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Цвет события</label>
                            <div class="d-flex align-items-center gap-3">
                                <input type="color" name="color" class="form-control" style="width: 80px; height: 50px; padding: 5px;"
                                       value="{{ old('color', '#667eea') }}">
                                <input type="text" class="form-control" id="colorHex" value="{{ old('color', '#667eea') }}"
                                       placeholder="#667eea" style="flex: 1;">
                            </div>
                            @error('color') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Порядок сортировки</label>
                            <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror"
                                   value="{{ old('sort_order', 0) }}" placeholder="Число для сортировки">
                            @error('sort_order') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="d-flex justify-content-between gap-3">
                            <a href="{{ route('events.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Назад
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Сохранить событие
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const colorPicker = document.querySelector('input[type="color"]');
    const colorHex = document.getElementById('colorHex');

    colorPicker.addEventListener('change', function() {
        colorHex.value = this.value;
    });

    colorHex.addEventListener('input', function() {
        colorPicker.value = this.value;
    });
</script>
</body>
</html>
