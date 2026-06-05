@extends('layouts.app')

@section('title', 'Редактировать пользователя')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}" class="text-decoration-none">Пользователи</a></li>
    <li class="breadcrumb-item active">Редактировать</li>
@endsection

@section('content')
<div class="page-header">
    <h1>Редактировать пользователя</h1>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('users.update', $user) }}">
            @csrf
            @method('PUT')
            @include('portal.users._form')
            <button class="btn btn-primary">Сохранить</button>
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Отмена</a>
        </form>
    </div>
</div>
@endsection
