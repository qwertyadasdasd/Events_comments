<!DOCTYPE html>
<html>
<head>
    <title>Создать событие</title>
</head>
<body>
<div class="container mt-5">
    <form action="/events" method="POST">
        @csrf
        <div class="mb-3">
            <label>Название события</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Slug</label>
            <input type="text" name="slug" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Адрес</label>
            <input type="text" name="address" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Описание</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label>Количество гостей</label>
            <input type="number" name="guests" class="form-control" value="0">
        </div>

        <div class="mb-3">
            <label>Дата начала</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Дата окончания</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Цвет</label>
            <input type="color" name="color" class="form-control" value="#000000">
        </div>

        <div class="mb-3">
            <label>Порядок сортировки</label>
            <input type="number" name="sort_order" class="form-control" value="0">
        </div>

        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="/events" class="btn btn-secondary">Назад</a>
    </form>
</div>
</body>
</html>
