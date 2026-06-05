@extends('layouts.app')

@section('title', 'Редактировать настройку')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('settings.index') }}" class="text-decoration-none">Настройки</a></li>
    <li class="breadcrumb-item active">Редактировать</li>
@endsection

@section('content')
<div class="page-header">
    <h1>Редактировать настройку</h1>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('settings.update', $setting) }}">
            @csrf
            @method('PUT')
            @include('portal.settings._form')
            <button class="btn btn-primary">Сохранить</button>
            <a href="{{ route('settings.index') }}" class="btn btn-outline-secondary">Отмена</a>
        </form>
    </div>
</div>
@endsection
