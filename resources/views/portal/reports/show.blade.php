@extends('layouts.app')

@section('title', 'Просмотр отчёта')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('reports.index') }}" class="text-decoration-none">Отчёты</a></li>
    <li class="breadcrumb-item active">Просмотр</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-start gap-2">
    <div><h1>{{ $report->name }}</h1></div>
    <div class="d-flex gap-2">
        <a href="{{ route('reports.edit', $report) }}" class="btn btn-outline-primary btn-sm">Редактировать</a>
        <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary btn-sm">Назад</a>
    </div>
</div>
<div class="card"><div class="card-body">
    <p><strong>Тип:</strong> {{ $report->type }}</p>
    <p><strong>Период:</strong> {{ $report->period_start?->format('d.m.Y') ?? '-' }} - {{ $report->period_end?->format('d.m.Y') ?? '-' }}</p>
    <p><strong>Сформировал:</strong> {{ $report->generatedByUser?->name ?? '-' }}</p>
    <p><strong>Дата формирования:</strong> {{ $report->generated_at?->format('d.m.Y H:i') ?? '-' }}</p>
    <p class="mb-0"><strong>Payload:</strong> {{ $report->payload ? json_encode($report->payload, JSON_UNESCAPED_UNICODE) : '-' }}</p>
</div></div>
@endsection
