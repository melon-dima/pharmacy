@extends('layouts.app')

@section('title', 'Просмотр настройки')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('settings.index') }}" class="text-decoration-none">Настройки</a></li>
    <li class="breadcrumb-item active">Просмотр</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-start gap-2">
    <div><h1>Настройка: {{ $setting->key }}</h1></div>
    <div class="d-flex gap-2">
        <a href="{{ route('settings.edit', $setting) }}" class="btn btn-outline-primary btn-sm">Редактировать</a>
        <a href="{{ route('settings.index') }}" class="btn btn-outline-secondary btn-sm">Назад</a>
    </div>
</div>
<div class="card"><div class="card-body">
    <p><strong>Группа:</strong> {{ $setting->group ?? '-' }}</p>
    <p><strong>Ключ:</strong> {{ $setting->key }}</p>
    <p><strong>Значение:</strong> {{ $setting->value ?? '-' }}</p>
    <p class="mb-0"><strong>Описание:</strong> {{ $setting->description ?? '-' }}</p>
</div></div>
@endsection
