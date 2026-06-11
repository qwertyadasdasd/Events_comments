@extends('layouts.app')

@section('title', 'Комментарии')

@section('content')
    <style>
        .comments-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .comments-title h1 {
            font-size: 28px;
            font-weight: 700;
            color: white;
            margin: 0;
        }

        .comments-title p {
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

        .comments-table-wrapper {
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.15);
        }

        .comments-table {
            width: 100%;
            border-collapse: collapse;
        }

        .comments-table thead tr {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .comments-table th {
            padding: 18px 20px;
            color: white;
            font-weight: 600;
            font-size: 14px;
            text-align: left;
        }

        .comments-table td {
            padding: 16px 20px;
            color: #374151;
            font-size: 14px;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }

        .comments-table tbody tr:hover {
            background: #f9fafb;
        }

        .comments-table tbody tr:last-child td {
            border-bottom: none;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-approved {
            background: #d1fae5;
            color: #059669;
        }

        .status-pending {
            background: #fed7aa;
            color: #c2410c;
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

        .comment-preview {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .pagination-wrapper {
            padding: 20px 24px;
            border-top: 1px solid #f3f4f6;
        }

        @media (max-width: 768px) {
            .comments-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .comments-table th,
            .comments-table td {
                padding: 12px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 6px;
            }

            .comment-preview {
                max-width: 150px;
            }
        }
    </style>

    <div class="comments-header">
        <div class="comments-title">
            <h1>Комментарии</h1>
            <p>Управление отзывами и комментариями пользователей</p>
        </div>
        <a href="{{ route('comments.create') }}" class="btn-create">
            <span>+</span> Добавить комментарий
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="comments-table-wrapper">
        <table class="comments-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Автор</th>
                <th>Комментарий</th>
                <th>Пост ID</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @forelse($comments as $comment)
                <tr>
                    <td>{{ $comment->id }}</td>
                    <td>
                        <strong>{{ $comment->name }}</strong>
                        <br>
                        <small style="color: #9ca3af; font-size: 12px;">{{ $comment->email }}</small>
                    </td>
                    <td>
                        <div class="comment-preview">
                            {{ Str::limit($comment->comment, 60) }}
                        </div>
                    </td>
                    <td>{{ $comment->post_id ?? '—' }}</td>
                    <td>
                        @if($comment->approved)
                            <span class="status-badge status-approved">Одобрен</span>
                        @else
                            <span class="status-badge status-pending">На модерации</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('comments.edit', $comment) }}" class="btn-edit">Редактировать</a>
                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" onclick="return confirm('Вы уверены, что хотите удалить этот комментарий?')">
                                    Удалить
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="empty-state">
                        <p>Нет созданных комментариев</p>
                        <a href="{{ route('comments.create') }}">Добавить первый комментарий →</a>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        @if(isset($comments) && method_exists($comments, 'links'))
            <div class="pagination-wrapper">
                {{ $comments->links() }}
            </div>
        @endif
    </div>
@endsection
