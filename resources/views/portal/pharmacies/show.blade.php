@extends('layouts.app')

@section('title', 'Просмотр аптеки')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('pharmacies.index') }}" class="text-decoration-none">Аптеки</a></li>
    <li class="breadcrumb-item active">Просмотр</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-start gap-2">
    <div><h1>{{ $pharmacy->name }}</h1></div>
    <div class="d-flex gap-2">
        <a href="{{ route('pharmacies.edit', $pharmacy) }}" class="btn btn-outline-primary btn-sm">Редактировать</a>
        <a href="{{ route('pharmacies.index') }}" class="btn btn-outline-secondary btn-sm">Назад</a>
    </div>
</div>
<div class="card"><div class="card-body">
    <p><strong>Код:</strong> {{ $pharmacy->code ?? '-' }}</p>
    <p><strong>Адрес:</strong> {{ $pharmacy->address ?? '-' }}</p>
    <p><strong>Телефон:</strong> {{ $pharmacy->phone ?? '-' }}</p>
    <p><strong>Сотрудники:</strong> {{ $pharmacy->employees->count() }}</p>
    <p><strong>Смены:</strong> {{ $pharmacy->shifts->count() }}</p>
    <p><strong>Чек-листы:</strong> {{ $pharmacy->checklists->count() }}</p>
    <p class="mb-0"><strong>Статус:</strong> {{ $pharmacy->is_active ? 'Активна' : 'Неактивна' }}</p>
</div></div>
@endsection
