<!DOCTYPE html>
<html>
<head>
    <title>Комментарии</title>
</head>
<body>
<div class="container mt-5">
    <a href="/comments/create" class="btn btn-success mb-3">Добавить</a>

    <table class="table">
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
        @foreach($comments as $comment)
            <tr>
                <td>{{ $comment->id }}</td>
                <td>{{ $comment->name }}</td>
                <td>{{ $comment->email }}</td>
                <td>{{ Str::limit($comment->comment, 30) }}</td>
                <td>{{ $comment->approved ? 'Да' : 'Нет' }}</td>
                <td>
                    <a href="/comments/{{ $comment->id }}/edit" class="btn btn-sm btn-primary">Ред.</a>
                    <form action="/comments/{{ $comment->id }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить?')">Уд.</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
