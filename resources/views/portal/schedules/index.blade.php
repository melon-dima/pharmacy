@extends('layouts.app')

@section('title', 'Графики смен')

@section('breadcrumb')
    <li class="breadcrumb-item active">Графики смен</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-2">
    <div>
        <h1>Графики смен</h1>
        <div class="subtitle">Список смен сотрудников по аптекам</div>
    </div>
    <a href="{{ route('schedules.create') }}" class="btn btn-primary btn-sm">
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
                        <th>Аптека</th>
                        <th>Начало</th>
                        <th>Окончание</th>
                        <th>Статус</th>
                        <th class="pe-3 text-end">Действия</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($shifts as $shift)
                    <tr>
                        <td class="ps-3">{{ $shift->employee?->full_name ?? '-' }}</td>
                        <td>{{ $shift->pharmacy?->name ?? '-' }}</td>
                        <td>{{ $shift->starts_at?->format('d.m.Y H:i') }}</td>
                        <td>{{ $shift->ends_at?->format('d.m.Y H:i') }}</td>
                        <td>{{ $shift->status }}</td>
                        <td class="pe-3 text-end">
                            <a href="{{ route('schedules.show', $shift) }}" class="btn btn-sm btn-outline-secondary">Просмотр</a>
                            <a href="{{ route('schedules.edit', $shift) }}" class="btn btn-sm btn-outline-primary">Редактировать</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">Пока нет смен</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $shifts->links() }}
</div>
@endsection
