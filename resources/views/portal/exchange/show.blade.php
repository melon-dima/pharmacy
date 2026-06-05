@extends('layouts.app')

@section('title', 'Просмотр обмена')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('exchange.index') }}" class="text-decoration-none">Обмены с 1С</a></li>
    <li class="breadcrumb-item active">Просмотр</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-start gap-2">
    <div><h1>Обмен #{{ $exchange->id }}</h1></div>
    <div class="d-flex gap-2">
        <a href="{{ route('exchange.edit', $exchange) }}" class="btn btn-outline-primary btn-sm">Редактировать</a>
        <a href="{{ route('exchange.index') }}" class="btn btn-outline-secondary btn-sm">Назад</a>
    </div>
</div>
<div class="card"><div class="card-body">
    <p><strong>Система:</strong> {{ $exchange->system }}</p>
    <p><strong>Направление:</strong> {{ $exchange->direction }}</p>
    <p><strong>Статус:</strong> {{ $exchange->status }}</p>
    <p><strong>Время:</strong> {{ $exchange->exchanged_at?->format('d.m.Y H:i') ?? '-' }}</p>
    <p><strong>Payload:</strong> {{ $exchange->payload ? json_encode($exchange->payload, JSON_UNESCAPED_UNICODE) : '-' }}</p>
    <p class="mb-0"><strong>Ответ:</strong> {{ $exchange->response ?? '-' }}</p>
</div></div>
@endsection
