<!DOCTYPE html>
<html>
<head>
    <title>Редактировать событие</title>
</head>
<body>
<div class="container mt-5">
    <form action="/events/{{ $event->id }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Название события</label>
            <input type="text" name="name" class="form-control" value="{{ $event->name }}" required>
        </div>

        <div class="mb-3">
            <label>Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ $event->slug }}" required>
        </div>

        <div class="mb-3">
            <label>Адрес</label>
            <input type="text" name="address" class="form-control" value="{{ $event->address }}" required>
        </div>

        <div class="mb-3">
            <label>Описание</label>
            <textarea name="description" class="form-control" rows="3">{{ $event->description }}</textarea>
        </div>

        <div class="mb-3">
            <label>Количество гостей</label>
            <input type="number" name="guests" class="form-control" value="{{ $event->guests }}">
        </div>

        <div class="mb-3">
            <label>Дата начала</label>
            <input type="date" name="start_date" class="form-control" value="{{ $event->start_date }}" required>
        </div>

        <div class="mb-3">
            <label>Дата окончания</label>
            <input type="date" name="end_date" class="form-control" value="{{ $event->end_date }}" required>
        </div>

        <div class="mb-3">
            <label>Цвет</label>
            <input type="color" name="color" class="form-control" value="{{ $event->color ?? '#000000' }}">
        </div>

        <div class="mb-3">
            <label>Порядок сортировки</label>
            <input type="number" name="sort_order" class="form-control" value="{{ $event->sort_order }}">
        </div>

        <button type="submit" class="btn btn-primary">Обновить</button>
        <a href="/events" class="btn btn-secondary">Назад</a>
    </form>
</div>
</body>
</html>
