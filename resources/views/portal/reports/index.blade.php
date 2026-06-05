@extends('layouts.app')

@section('title', 'Отчёты')

@section('breadcrumb')
    <li class="breadcrumb-item active">Отчёты</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-2">
    <div>
        <h1>Отчёты</h1>
        <div class="subtitle">Сформированные аналитические отчёты</div>
    </div>
    <a href="{{ route('reports.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Добавить
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Название</th>
                        <th>Тип</th>
                        <th>Период</th>
                        <th>Сформирован</th>
                        <th>Кем</th>
                        <th class="pe-3 text-end">Действия</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($reports as $report)
                    <tr>
                        <td class="ps-3">{{ $report->name }}</td>
                        <td>{{ $report->type }}</td>
                        <td>
                            {{ $report->period_start?->format('d.m.Y') ?? '-' }}
                            -
                            {{ $report->period_end?->format('d.m.Y') ?? '-' }}
                        </td>
                        <td>{{ $report->generated_at?->format('d.m.Y H:i') ?? '-' }}</td>
                        <td>{{ $report->generatedByUser?->name ?? '-' }}</td>
                        <td class="pe-3 text-end">
                            <a href="{{ route('reports.show', $report) }}" class="btn btn-sm btn-outline-secondary">Просмотр</a>
                            <a href="{{ route('reports.edit', $report) }}" class="btn btn-sm btn-outline-primary">Редактировать</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">Пока нет отчётов</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $reports->links() }}
</div>
@endsection
