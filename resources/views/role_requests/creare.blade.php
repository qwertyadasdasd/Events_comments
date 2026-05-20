@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Запрос на повышение роли</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($hasPendingRequest)
            <div class="alert alert-warning">
                У вас уже есть активный запрос на повышение роли. Дождитесь его обработки.
            </div>
        @else
            <form action="{{ route('role-request.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Текущая роль: {{ Auth::user()->role }}</label>
                </div>

                <div class="form-group">
                    <label for="requested_role">Желаемая роль:</label>
                    <select name="requested_role" id="requested_role" class="form-control @error('requested_role') is-invalid @enderror">
                        @foreach($availableRoles as $role)
                            <option value="{{ $role }}" {{ old('requested_role') == $role ? 'selected' : '' }}>
                                {{ ucfirst($role) }}
                            </option>
                        @endforeach
                    </select>
                    @error('requested_role')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="reason">Причина повышения роли:</label>
                    <textarea name="reason" id="reason" class="form-control @error('reason') is-invalid @enderror" rows="4"
                              placeholder="Опишите, почему вы хотите повысить свою роль...">{{ old('reason') }}</textarea>
                    @error('reason')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Отправить запрос</button>
            </form>
        @endif
    </div>
@endsection
