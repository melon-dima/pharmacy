@extends('layouts.app')

@section('title', 'Просмотр смены')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('schedules.index') }}" class="text-decoration-none">Графики смен</a></li>
    <li class="breadcrumb-item active">Просмотр</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-start gap-2">
    <div><h1>Смена #{{ $shift->id }}</h1></div>
    <div class="d-flex gap-2">
        <a href="{{ route('schedules.edit', $shift) }}" class="btn btn-outline-primary btn-sm">Редактировать</a>
        <a href="{{ route('schedules.index') }}" class="btn btn-outline-secondary btn-sm">Назад</a>
    </div>
</div>
<div class="card"><div class="card-body">
    <p><strong>Сотрудник:</strong> {{ $shift->employee?->full_name ?? '-' }}</p>
    <p><strong>Аптека:</strong> {{ $shift->pharmacy?->name ?? '-' }}</p>
    <p><strong>Начало:</strong> {{ $shift->starts_at?->format('d.m.Y H:i') }}</p>
    <p><strong>Окончание:</strong> {{ $shift->ends_at?->format('d.m.Y H:i') }}</p>
    <p><strong>Статус:</strong> {{ $shift->status }}</p>
    <p class="mb-0"><strong>Примечание:</strong> {{ $shift->notes ?? '-' }}</p>
</div></div>
@endsection
