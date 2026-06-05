@extends('layouts.app')

@section('title', 'Аптеки')

@section('breadcrumb')
    <li class="breadcrumb-item active">Аптеки</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-2">
    <div>
        <h1>Аптеки</h1>
        <div class="subtitle">Справочник аптек сети</div>
    </div>
    <a href="{{ route('pharmacies.create') }}" class="btn btn-primary btn-sm">
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
                        <th>Код</th>
                        <th>Адрес</th>
                        <th>Телефон</th>
                        <th>Сотрудники</th>
                        <th>Статус</th>
                        <th class="pe-3 text-end">Действия</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($pharmacies as $pharmacy)
                    <tr>
                        <td class="ps-3">{{ $pharmacy->name }}</td>
                        <td>{{ $pharmacy->code ?? '-' }}</td>
                        <td>{{ $pharmacy->address ?? '-' }}</td>
                        <td>{{ $pharmacy->phone ?? '-' }}</td>
                        <td>{{ $pharmacy->employees_count ?? 0 }}</td>
                        <td>{{ $pharmacy->is_active ? 'Активна' : 'Неактивна' }}</td>
                        <td class="pe-3 text-end">
                            <a href="{{ route('pharmacies.show', $pharmacy) }}" class="btn btn-sm btn-outline-secondary">Просмотр</a>
                            <a href="{{ route('pharmacies.edit', $pharmacy) }}" class="btn btn-sm btn-outline-primary">Редактировать</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">Пока нет аптек</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $pharmacies->links() }}
</div>
@endsection
