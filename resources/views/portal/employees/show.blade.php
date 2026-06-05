@extends('layouts.app')

@section('title', 'Просмотр сотрудника')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('employees.index') }}" class="text-decoration-none">Сотрудники</a></li>
    <li class="breadcrumb-item active">Просмотр</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-start gap-2">
    <div><h1>{{ $employee->full_name }}</h1></div>
    <div class="d-flex gap-2">
        <a href="{{ route('employees.edit', $employee) }}" class="btn btn-outline-primary btn-sm">Редактировать</a>
        <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary btn-sm">Назад</a>
    </div>
</div>
<div class="card"><div class="card-body">
    <p><strong>Должность:</strong> {{ $employee->position ?? '-' }}</p>
    <p><strong>Аптека:</strong> {{ $employee->pharmacy?->name ?? '-' }}</p>
    <p><strong>Email:</strong> {{ $employee->email ?? '-' }}</p>
    <p><strong>Телефон:</strong> {{ $employee->phone ?? '-' }}</p>
    <p><strong>Дата найма:</strong> {{ $employee->hired_at?->format('d.m.Y') ?? '-' }}</p>
    <p class="mb-0"><strong>Статус:</strong> {{ $employee->is_active ? 'Активен' : 'Неактивен' }}</p>
</div></div>
@endsection
