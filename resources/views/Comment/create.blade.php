<!DOCTYPE html>
<html>
<head>
    <title>Добавить комментарий</title>
</head>
<body>
<div class="container mt-5">
    <form action="/comments" method="POST">
        @csrf
        <div class="mb-3">
            <label>Имя</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Комментарий</label>
            <textarea name="comments" class="form-control" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label>ID поста</label>
            <input type="number" name="post_id" class="form-control">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="approved" class="form-check-input" value="1">
            <label class="form-check-label">Одобрен</label>
        </div>

        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="/comments" class="btn btn-secondary">Назад</a>
    </form>
</div>
</body>
</html>
