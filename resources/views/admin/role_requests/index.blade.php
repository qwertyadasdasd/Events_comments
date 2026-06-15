<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div class="admin-container">
    <h1>Управление заявками: </h1>
    <table class="data-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Пользователь</th>
            <th>Текущая роль</th>
            <th>Запрашиваемая роль</th>
            <th>Причина</th>
            <th>Дата подачи</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @forelse($requests as $request)
            <tr>
                <td>{{ $request->id }}</td>
                <td>
                    <strong>{{ $request->user->name }}</strong>
                    <small>{{ $request->user->email }}</small>
                </td>
                <td>{{ $request->user->role }}</td>
                <td><span style="color:aqua;">{{ $request->requested_role }}</span></td>
                <td>{{ $request->reason }}</td>
                <td>{{ $request->created_at->format('d.m.Y H:i') }}</td>
                <td>
                    <a href="{{ route('admin.role_requests.show', $request) }}" class="btn btn-view">Просмотр</a>

                    <form action="{{ route('admin.role_requests.approve', $request) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-approve" onclick="return confirm('Вы собираетесь повысить права пользователя в системе?')">Подтвердить запрос</button>
                    </form>

                    <form action="{{ route('admin.role_requests.reject', $request) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-reject">Отклонить заявку</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td style="text-align: center;">Новых заявок нет.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
</body>
</html>
