<!DOCTYPE html>
<html>
<head>
    <title>Редактировать событие</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Редактировать событие</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    <form action="{{ route('events.update', $event) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Название события</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $event->name) }}" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug', $event->slug) }}" required>
            @error('slug') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Описание</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $event->description) }}</textarea>
            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Дата события</label>
            <input type="date" name="event_date" class="form-control" value="{{ old('event_date', $event->event_date) }}" required>
            @error('event_date') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Местоположение</label>
            <input type="text" name="location" class="form-control" value="{{ old('location', $event->location) }}" required>
            @error('location') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Цвет (HEX)</label>
            <input type="color" name="color" class="form-control" value="{{ old('color', $event->color ?? '#000000') }}">
            @error('color') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Порядок сортировки</label>
            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $event->sort_order) }}">
            @error('sort_order') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Обновить</button>
        <a href="{{ route('events.index') }}" class="btn btn-secondary">Назад</a>
    </form>
</div>
</body>
</html>
