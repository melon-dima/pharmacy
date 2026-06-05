@extends('layouts.app')

@section('title', 'Просмотр заявки')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('requests.index') }}" class="text-decoration-none">Заявки</a></li>
    <li class="breadcrumb-item active">Просмотр</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-start gap-2">
    <div><h1>Заявка #{{ $request->id }}</h1></div>
    <div class="d-flex gap-2">
        <a href="{{ route('requests.edit', $request) }}" class="btn btn-outline-primary btn-sm">Редактировать</a>
        <a href="{{ route('requests.index') }}" class="btn btn-outline-secondary btn-sm">Назад</a>
    </div>
</div>
<div class="card"><div class="card-body">
    <p><strong>Сотрудник:</strong> {{ $request->employee?->full_name ?? '-' }}</p>
    <p><strong>Тип:</strong> {{ $request->type }}</p>
    <p><strong>Период:</strong> {{ $request->starts_on?->format('d.m.Y') ?? '-' }} - {{ $request->ends_on?->format('d.m.Y') ?? '-' }}</p>
    <p><strong>Статус:</strong> {{ $request->status }}</p>
    <p><strong>Согласовал:</strong> {{ $request->approvedByUser?->name ?? '-' }}</p>
    <p class="mb-0"><strong>Причина:</strong> {{ $request->reason ?? '-' }}</p>
</div></div>
@endsection
