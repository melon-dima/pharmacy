@extends('layouts.app')

@section('title', 'Каталог лекарств')

@section('breadcrumb')
    <li class="breadcrumb-item active">Каталог лекарств</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-2">
    <div>
        <h1>Каталог лекарств</h1>
        <div class="subtitle">Справочник товаров для портала, учета и мобильного приложения</div>
    </div>
    <a href="{{ route('medicines.create') }}" class="btn btn-primary btn-sm">
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
                        <th>Цена</th>
                        <th>Остатки</th>
                        <th>Интеграция</th>
                        <th>Статус</th>
                        <th class="pe-3 text-end">Действия</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($medicines as $medicine)
                    <tr>
                        <td class="ps-3">
                            <div class="fw-semibold">{{ $medicine->name }}</div>
                            <div class="text-muted small">{{ $medicine->manufacturer ?? '-' }}</div>
                        </td>
                        <td>{{ $medicine->sku ?? '-' }}</td>
                        <td>{{ number_format($medicine->price_cents / 100, 2, '.', ' ') }} {{ $medicine->currency }}</td>
                        <td>{{ $medicine->inventory_items_count ?? 0 }}</td>
                        <td>
                            @if($medicine->external_system && $medicine->external_id)
                                {{ $medicine->external_system }}: {{ $medicine->external_id }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $medicine->is_active ? 'Активно' : 'Выключено' }}</td>
                        <td class="pe-3 text-end">
                            <a href="{{ route('medicines.show', $medicine) }}" class="btn btn-sm btn-outline-secondary">Просмотр</a>
                            <a href="{{ route('medicines.edit', $medicine) }}" class="btn btn-sm btn-outline-primary">Редактировать</a>
                            @if($medicine->is_active)
                                <form method="POST" action="{{ route('medicines.destroy', $medicine) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Выключить</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">Пока нет лекарств</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $medicines->links() }}
</div>
@endsection
