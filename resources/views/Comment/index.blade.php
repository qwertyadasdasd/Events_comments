<!DOCTYPE html>
<html>
<head>
    <title>Комментарии</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Комментарии</h1>
    <a href="{{ route('comments.create') }}" class="btn btn-success mb-3">➕ Добавить комментарий</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Email</th>
            <th>Комментарий</th>
            <th>Одобрен</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @forelse($comments as $comment)
            <tr>
                <td>{{ $comment->id }}</td>
                <td>{{ $comment->name }}</td>
                <td>{{ $comment->email }}</td>
                <td>{{ Str::limit($comment->comment, 50) }}</td>
                <td>{{ $comment->approved ? '✅ Да' : '❌ Нет' }}</td>
                <td>
                    <a href="{{ route('comments.edit', $comment) }}" class="btn btn-sm btn-primary">Ред.</a>
                    <form action="{{ route('comments.destroy', $comment) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить комментарий?')">Уд.</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">Нет комментариев</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $comments->links() }}
</div>
</body>
</html>
