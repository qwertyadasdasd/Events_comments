<!DOCTYPE html>
<html>
<head>
    <title>Редактировать комментарий</title>
</head>
<body>
<div class="container mt-5">
    <form action="/comment/{{ $comment->id }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Имя</label>
            <input type="text" name="name" class="form-control" value="{{ $comment->name }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $comment->email }}" required>
        </div>

        <div class="mb-3">
            <label>Комментарий</label>
            <textarea name="comment" class="form-control" rows="4" required>{{ $comment->comment }}</textarea>
        </div>

        <div class="mb-3">
            <label>ID поста</label>
            <input type="number" name="post_id" class="form-control" value="{{ $comment->post_id }}">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="approved" class="form-check-input" value="1" {{ $comment->approved ? 'checked' : '' }}>
            <label class="form-check-label">Одобрен</label>
        </div>

        <button type="submit" class="btn btn-primary">Обновить</button>
        <a href="/comment" class="btn btn-secondary">Назад</a>
    </form>
</div>
</body>
</html>
