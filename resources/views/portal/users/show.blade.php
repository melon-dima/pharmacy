@extends('layouts.app')

@section('title', 'Просмотр пользователя')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}" class="text-decoration-none">Пользователи</a></li>
    <li class="breadcrumb-item active">Просмотр</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-start gap-2">
    <div><h1>{{ $user->name }}</h1></div>
    <div class="d-flex gap-2">
        <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-primary btn-sm">Редактировать</a>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm">Назад</a>
    </div>
</div>
<div class="card"><div class="card-body">
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Ролей:</strong> {{ $user->roles->count() }}</p>
    <p><strong>RBAC назначений:</strong> {{ $user->authAssignments->count() }}</p>
    <p class="mb-0"><strong>Создан:</strong> {{ $user->created_at?->format('d.m.Y H:i') }}</p>
</div></div>
@endsection
