<!DOCTYPE html>
<html>
<head>
    <title>События</title>
</head>
<body>
<div class="container mt-5">
    <h1>Список событий</h1>
    <a href="/events/create" class="btn btn-success mb-3">Создать событие</a>

    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Slug</th>
            <th>Адрес</th>
            <th>Дата начала</th>
            <th>Дата окончания</th>
            <th>Гости</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($events as $event)
            <tr>
                <td>{{ $event->id }}</td>
                <td>{{ $event->name }}</td>
                <td>{{ $event->slug }}</td>
                <td>{{ $event->address }}</td>
                <td>{{ $event->start_date }}</td>
                <td>{{ $event->end_date }}</td>
                <td>{{ $event->guests }}</td>
                <td>
                    <a href="/events/{{ $event->id }}/edit" class="btn btn-sm btn-primary">Ред.</a>
                    <form action="/events/{{ $event->id }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить событие?')">Уд.</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
