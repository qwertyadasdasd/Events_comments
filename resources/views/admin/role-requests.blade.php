@extends('layouts.app')

@section('title', 'Управление запросами')

@section('content')
    <style>
        .admin-header {
            margin-bottom: 32px;
        }
        .admin-title {
            font-size: 28px;
            font-weight: 700;
            color: white;
            margin-bottom: 8px;
        }
        .admin-subtitle {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
        }
        .card {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 40px -12px rgba(0,0,0,0.15);
        }
        .card-body {
            padding: 30px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th {
            text-align: left;
            padding: 12px;
            background: #f9fafb;
            font-weight: 600;
        }
        .table td {
            padding: 12px;
            border-bottom: 1px solid #f3f4f6;
        }
        .btn-approve {
            background: #10b981;
            color: white;
            padding: 6px 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-right: 8px;
        }
        .btn-reject {
            background: #ef4444;
            color: white;
            padding: 6px 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        .status-pending {
            color: #f59e0b;
            font-weight: 600;
        }
        .status-approved {
            color: #10b981;
            font-weight: 600;
        }
        .status-rejected {
            color: #ef4444;
            font-weight: 600;
        }
        .alert-success {
            background: #d1fae5;
            color: #059669;
            padding: 12px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
        }
    </style>

    <div class="admin-header">
        <h1 class="admin-title">Управление запросами на роль</h1>
        <p class="admin-subtitle">Одобрение или отклонение запросов пользователей</p>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th>Пользователь</th>
                    <th>Текущая роль</th>
                    <th>Желаемая роль</th>
                    <th>Причина</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @forelse($requests as $req)
                    <tr>
                        <td>
                            <strong>{{ $req->user->name }}</strong>
                            <br>
                            <small style="color: #9ca3af;">{{ $req->user->email }}</small>
                        </td>
                        <td>{{ $req->current_role ?? 'user' }}</td>
                        <td>{{ $req->requested_role }}</td>
                        <td>{{ $req->reason }}</td>
                        <td>
                            @if($req->status == 'pending')
                                <span class="status-pending">На рассмотрении</span>
                            @elseif($req->status == 'approved')
                                <span class="status-approved">Одобрен</span>
                            @else
                                <span class="status-rejected">Отклонен</span>
                            @endif
                        </td>
                        <td>
                            @if($req->status == 'pending')
                                <form action="{{ route('admin.role-requests.approve', $req->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-approve">Одобрить</button>
                                </form>
                                <form action="{{ route('admin.role-requests.reject', $req->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-reject">Отклонить</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px;">Нет запросов</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
