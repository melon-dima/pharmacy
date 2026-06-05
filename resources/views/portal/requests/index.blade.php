@extends('layouts.app')

@section('title', 'Заявки')

@section('breadcrumb')
    <li class="breadcrumb-item active">Заявки</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-2">
    <div>
        <h1>Заявки</h1>
        <div class="subtitle">Заявки сотрудников на согласование</div>
    </div>
    <a href="{{ route('requests.create') }}" class="btn btn-primary btn-sm">
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
                        <th>Тип</th>
                        <th>Период</th>
                        <th>Статус</th>
                        <th>Решение</th>
                        <th class="pe-3 text-end">Действия</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($requests as $request)
                    <tr>
                        <td class="ps-3">{{ $request->employee?->full_name ?? '-' }}</td>
                        <td>{{ $request->type }}</td>
                        <td>
                            {{ $request->starts_on?->format('d.m.Y') ?? '-' }}
                            -
                            {{ $request->ends_on?->format('d.m.Y') ?? '-' }}
                        </td>
                        <td>{{ $request->status }}</td>
                        <td>{{ $request->decided_at?->format('d.m.Y H:i') ?? '-' }}</td>
                        <td class="pe-3 text-end">
                            <a href="{{ route('requests.show', $request) }}" class="btn btn-sm btn-outline-secondary">Просмотр</a>
                            <a href="{{ route('requests.edit', $request) }}" class="btn btn-sm btn-outline-primary">Редактировать</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">Пока нет заявок</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $requests->links() }}
</div>
@endsection
