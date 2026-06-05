@extends('layouts.app')

@section('title', 'Сотрудники')

@section('breadcrumb')
    <li class="breadcrumb-item active">Сотрудники</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-2">
    <div>
        <h1>Сотрудники</h1>
        <div class="subtitle">Кадровый состав сети аптек</div>
    </div>
    <a href="{{ route('employees.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Добавить
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">ФИО</th>
                        <th>Должность</th>
                        <th>Аптека</th>
                        <th>Email</th>
                        <th>Статус</th>
                        <th class="pe-3 text-end">Действия</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($employees as $employee)
                    <tr>
                        <td class="ps-3">{{ $employee->full_name }}</td>
                        <td>{{ $employee->position ?? '-' }}</td>
                        <td>{{ $employee->pharmacy?->name ?? '-' }}</td>
                        <td>{{ $employee->email ?? '-' }}</td>
                        <td>{{ $employee->is_active ? 'Активен' : 'Неактивен' }}</td>
                        <td class="pe-3 text-end">
                            <a href="{{ route('employees.show', $employee) }}" class="btn btn-sm btn-outline-secondary">Просмотр</a>
                            <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-outline-primary">Редактировать</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">Пока нет сотрудников</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $employees->links() }}
</div>
@endsection
