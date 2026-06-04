<!DOCTYPE html>
<html>
<head>
    <title>События</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Список событий</h1>
    <a href="{{ route('events.create') }}" class="btn btn-success mb-3">➕ Создать событие</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Slug</th>
            <th>Местоположение</th>
            <th>Дата события</th>
            <th>Цвет</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @forelse($events as $event)
            <tr>
                <td>{{ $event->id }}</td>
                <td>{{ $event->name }}</td>
                <td>{{ $event->slug }}</td>
                <td>{{ $event->location }}</td>
                <td>{{ $event->event_date }}</td>
                <td><span style="background: {{ $event->color }}; padding: 3px 10px; border-radius: 5px;">{{ $event->color }}</span></td>
                <td>
                    <a href="{{ route('events.edit', $event) }}" class="btn btn-sm btn-primary">Ред.</a>
                    <form action="{{ route('events.destroy', $event) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить событие?')">Уд.</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">Нет событий</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $events->links() }}
</div>
</body>
</html>
