@extends('layouts.app')

@section('title', 'Просмотр чек-листа')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('checklists.index') }}" class="text-decoration-none">Чек-листы</a></li>
    <li class="breadcrumb-item active">Просмотр</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-start gap-2">
    <div><h1>Чек-лист: {{ $checklist->title }}</h1></div>
    <div class="d-flex gap-2">
        <a href="{{ route('checklists.edit', $checklist) }}" class="btn btn-outline-primary btn-sm">Редактировать</a>
        <a href="{{ route('checklists.index') }}" class="btn btn-outline-secondary btn-sm">Назад</a>
    </div>
</div>
<div class="card"><div class="card-body">
    <p><strong>Аптека:</strong> {{ $checklist->pharmacy?->name ?? 'Все' }}</p>
    <p><strong>Периодичность:</strong> {{ $checklist->frequency }}</p>
    <p><strong>Статус:</strong> {{ $checklist->is_active ? 'Активен' : 'Выключен' }}</p>
    <p><strong>Пунктов:</strong> {{ $checklist->items->count() }}</p>
    <p class="mb-0"><strong>Описание:</strong> {{ $checklist->description ?? '-' }}</p>
</div></div>
@endsection
