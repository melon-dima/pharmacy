@extends('layouts.app')

@section('title', 'Просмотр записи времени')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('timelog.index') }}" class="text-decoration-none">Учёт времени</a></li>
    <li class="breadcrumb-item active">Просмотр</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-start gap-2">
    <div><h1>Запись времени #{{ $timelog->id }}</h1></div>
    <div class="d-flex gap-2">
        <a href="{{ route('timelog.edit', $timelog) }}" class="btn btn-outline-primary btn-sm">Редактировать</a>
        <a href="{{ route('timelog.index') }}" class="btn btn-outline-secondary btn-sm">Назад</a>
    </div>
</div>
<div class="card"><div class="card-body">
    <p><strong>Сотрудник:</strong> {{ $timelog->employee?->full_name ?? '-' }}</p>
    <p><strong>Смена:</strong> {{ $timelog->shift_id ? '#'.$timelog->shift_id : '-' }}</p>
    <p><strong>Тип:</strong> {{ $timelog->type }}</p>
    <p><strong>Источник:</strong> {{ $timelog->source ?? '-' }}</p>
    <p><strong>Время:</strong> {{ $timelog->logged_at?->format('d.m.Y H:i') }}</p>
    <p class="mb-0"><strong>Meta:</strong> {{ $timelog->meta ? json_encode($timelog->meta, JSON_UNESCAPED_UNICODE) : '-' }}</p>
</div></div>
@endsection
