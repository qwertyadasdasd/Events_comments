@extends('layouts.app')

@section('content')
<div style="max-width: 900px; margin: 40px auto; background: white; border-radius: 20px; padding: 30px;">
    <h2>Мои запросы на роль</h2>
    
    @if($requests->count() > 0)
        <table style="width: 100%; border-collapse: collapse;">
            <tr style="background: #f0f0f0;">
                <th style="padding: 10px; text-align: left;">Дата</th>
                <th style="padding: 10px; text-align: left;">Роль</th>
                <th style="padding: 10px; text-align: left;">Статус</th>
            </tr>
            @foreach($requests as $req)
            <tr style="border-bottom: 1px solid #ddd;">
                <td style="padding: 10px;">{{ $req->created_at->format('d.m.Y') }}</td>
                <td style="padding: 10px;">{{ $req->requested_role }}</td>
                <td style="padding: 10px;">
                    @if($req->status == 'pending') ⏳ Ожидает
                    @elseif($req->status == 'approved') ✅ Одобрен
                    @else ❌ Отклонен
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
    @else
        <p>Нет запросов</p>
    @endif
    
    <a href="{{ route('dashboard') }}" style="display: inline-block; margin-top: 20px;">← Назад</a>
</div>
@endsection
