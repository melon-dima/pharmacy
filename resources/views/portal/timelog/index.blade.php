@extends('layouts.app')

@section('title', 'Учёт времени')

@section('breadcrumb')
    <li class="breadcrumb-item active">Учёт времени</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-2">
    <div>
        <h1>Учёт времени</h1>
        <div class="subtitle">Лог входов/выходов и событий времени</div>
    </div>
    <a href="{{ route('timelog.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Добавить
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Сотрудник</th>
                        <th>Событие</th>
                        <th>Время</th>
                        <th>Источник</th>
                        <th>Смена</th>
                        <th class="pe-3 text-end">Действия</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($timeLogs as $log)
                    <tr>
                        <td class="ps-3">{{ $log->employee?->full_name ?? '-' }}</td>
                        <td>{{ $log->type }}</td>
                        <td>{{ $log->logged_at?->format('d.m.Y H:i') }}</td>
                        <td>{{ $log->source ?? '-' }}</td>
                        <td>#{{ $log->shift_id ?? '-' }}</td>
                        <td class="pe-3 text-end">
                            <a href="{{ route('timelog.show', $log) }}" class="btn btn-sm btn-outline-secondary">Просмотр</a>
                            <a href="{{ route('timelog.edit', $log) }}" class="btn btn-sm btn-outline-primary">Редактировать</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">Пока нет записей</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $timeLogs->links() }}
</div>
@endsection
