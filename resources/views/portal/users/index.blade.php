@extends('layouts.app')

@section('title', 'Пользователи')

@section('breadcrumb')
    <li class="breadcrumb-item active">Пользователи</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-2">
    <div>
        <h1>Пользователи</h1>
        <div class="subtitle">Управление учетными записями системы</div>
    </div>
    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Добавить
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Имя</th>
                        <th>Email</th>
                        <th>Создан</th>
                        <th class="pe-3 text-end">Действия</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="ps-3">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at?->format('d.m.Y H:i') }}</td>
                        <td class="pe-3 text-end">
                            <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-outline-secondary">Просмотр</a>
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-primary">Редактировать</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-4 text-muted">Пока нет пользователей</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $users->links() }}
</div>
@endsection
