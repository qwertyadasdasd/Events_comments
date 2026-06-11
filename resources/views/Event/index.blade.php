@extends('layouts.app')

@section('title', 'События')

@section('content')
    <style>
        .events-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .events-title h1 {
            font-size: 28px;
            font-weight: 700;
            color: white;
            margin: 0;
        }

        .events-title p {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
            margin: 6px 0 0 0;
        }

        .btn-create {
            background: white;
            color: #667eea;
            padding: 12px 28px;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-create:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -8px rgba(0, 0, 0, 0.2);
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.15);
            backdrop-filter: blur(10px);
            color: #10b981;
            border: none;
            border-left: 4px solid #10b981;
            border-radius: 16px;
            padding: 16px 24px;
            margin-bottom: 24px;
        }

        .events-table-wrapper {
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.15);
        }

        .events-table {
            width: 100%;
            border-collapse: collapse;
        }

        .events-table thead tr {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .events-table th {
            padding: 18px 20px;
            color: white;
            font-weight: 600;
            font-size: 14px;
            text-align: left;
        }

        .events-table td {
            padding: 16px 20px;
            color: #374151;
            font-size: 14px;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }

        .events-table tbody tr:hover {
            background: #f9fafb;
        }

        .events-table tbody tr:last-child td {
            border-bottom: none;
        }

        .color-preview {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .color-dot {
            width: 24px;
            height: 24px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .btn-edit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s ease;
            display: inline-block;
        }

        .btn-edit:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(102, 126, 234, 0.3);
        }

        .btn-delete {
            background: none;
            border: none;
            color: #ef4444;
            cursor: pointer;
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-delete:hover {
            background: #fef2f2;
            transform: translateY(-1px);
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #9ca3af;
        }

        .empty-state p {
            margin-bottom: 20px;
        }

        .empty-state a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        /* Пагинация */
        .pagination-wrapper {
            padding: 20px 24px;
            border-top: 1px solid #f3f4f6;
        }

        @media (max-width: 768px) {
            .events-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .events-table th,
            .events-table td {
                padding: 12px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 6px;
            }
        }
    </style>

    <div class="events-header">
        <div class="events-title">
            <h1>События</h1>
            <p>Управление мероприятиями и событиями</p>
        </div>
        <a href="{{ route('events.create') }}" class="btn-create">
            <span>+</span> Создать событие
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="events-table-wrapper">
        <table class="events-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Местоположение</th>
                <th>Дата события</th>
                <th>Гости</th>
                <th>Цвет</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @forelse($events as $event)
                <tr>
                    <td>{{ $event->id }}</td>
                    <td>
                        <strong>{{ $event->name }}</strong>
                        @if($event->description)
                            <br>
                            <small style="color: #9ca3af; font-size: 12px;">
                                {{ Str::limit($event->description, 50) }}
                            </small>
                        @endif
                    </td>
                    <td>{{ $event->location ?? '—' }}</td>
                    <td>
                        @if($event->start_date)
                            {{ date('d.m.Y H:i', strtotime($event->start_date)) }}
                        @else
                            —
                        @endif
                    </td>
                    <td>{{ $event->guests ?? '—' }}</td>
                    <td>
                        <div class="color-preview">
                            <div class="color-dot" style="background: {{ $event->color ?? '#667eea' }}"></div>
                            <span>{{ $event->color ?? '#667eea' }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('events.edit', $event) }}" class="btn-edit">Редактировать</a>
                            <form action="{{ route('events.destroy', $event) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" onclick="return confirm('Вы уверены, что хотите удалить это событие?')">
                                    Удалить
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="empty-state">
                        <p>Нет созданных событий</p>
                        <a href="{{ route('events.create') }}">Создать первое событие →</a>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        @if(isset($events) && method_exists($events, 'links'))
            <div class="pagination-wrapper">
                {{ $events->links() }}
            </div>
        @endif
    </div>
@endsection
