@extends('layouts.app')

@section('title', 'Учет лекарств')

@section('breadcrumb')
    <li class="breadcrumb-item active">Учет лекарств</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-2">
    <div>
        <h1>Учет лекарств</h1>
        <div class="subtitle">Остатки лекарств по аптекам сети</div>
    </div>
    <a href="{{ route('inventory.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Добавить
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Аптека</th>
                        <th>Лекарство</th>
                        <th>Код</th>
                        <th>Количество</th>
                        <th>Минимум</th>
                        <th>Статус</th>
                        <th class="pe-3 text-end">Действия</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($items as $item)
                    <tr>
                        <td class="ps-3">{{ $item->pharmacy?->name ?? '-' }}</td>
                        <td>
                            <div class="fw-semibold">{{ $item->medicine?->name ?? '-' }}</div>
                            <div class="text-muted small">{{ $item->medicine?->manufacturer ?? '-' }}</div>
                        </td>
                        <td>{{ $item->medicine?->sku ?? '-' }}</td>
                        <td>{{ $item->quantity }} {{ $item->medicine?->unit }}</td>
                        <td>{{ $item->minimum_quantity }} {{ $item->medicine?->unit }}</td>
                        <td>
                            @if($item->isLowStock())
                                <span class="badge bg-warning text-dark">Мало</span>
                            @else
                                <span class="badge bg-success">Достаточно</span>
                            @endif
                        </td>
                        <td class="pe-3 text-end">
                            <a href="{{ route('inventory.show', $item) }}" class="btn btn-sm btn-outline-secondary">Просмотр</a>
                            <a href="{{ route('inventory.edit', $item) }}" class="btn btn-sm btn-outline-primary">Редактировать</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">Пока нет остатков лекарств</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $items->links() }}
</div>
@endsection
