<!DOCTYPE html>
<html>
<head>
    <title>Добавить комментарий</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Добавить комментарий</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    <form action="{{ route('comments.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Имя</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Комментарий</label>
            <textarea name="comment" class="form-control" rows="4" required>{{ old('comment') }}</textarea>
            @error('comment') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>ID поста</label>
            <input type="number" name="post_id" class="form-control" value="{{ old('post_id') }}">
            @error('post_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="approved" class="form-check-input" value="1" {{ old('approved') ? 'checked' : '' }}>
            <label class="form-check-label">Одобрен</label>
        </div>

        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{ route('comments.index') }}" class="btn btn-secondary">Назад</a>
    </form>
</div>
</body>
</html>
