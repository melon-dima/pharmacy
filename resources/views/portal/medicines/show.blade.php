@extends('layouts.app')

@section('title', 'Карточка лекарства')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('medicines.index') }}" class="text-decoration-none">Каталог лекарств</a></li>
    <li class="breadcrumb-item active">Просмотр</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-start gap-2">
    <div>
        <h1>{{ $medicine->name }}</h1>
        <div class="subtitle">{{ $medicine->sku ?? 'Без кода' }}</div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('medicines.edit', $medicine) }}" class="btn btn-outline-primary btn-sm">Редактировать</a>
        <a href="{{ route('medicines.index') }}" class="btn btn-outline-secondary btn-sm">Назад</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <p><strong>Код:</strong> {{ $medicine->sku ?? '-' }}</p>
        <p><strong>Производитель:</strong> {{ $medicine->manufacturer ?? '-' }}</p>
        <p><strong>Форма выпуска:</strong> {{ $medicine->dosage_form ?? '-' }}</p>
        <p><strong>Цена:</strong> {{ number_format($medicine->price_cents / 100, 2, '.', ' ') }} {{ $medicine->currency }}</p>
        <p><strong>Единица учета:</strong> {{ $medicine->unit }}</p>
        <p><strong>Статус:</strong> {{ $medicine->is_active ? 'Активно' : 'Выключено' }}</p>
        <p><strong>Внешняя система:</strong> {{ $medicine->external_system ?? '-' }}</p>
        <p><strong>Внешний ID:</strong> {{ $medicine->external_id ?? '-' }}</p>
        <p class="mb-0"><strong>Описание:</strong> {{ $medicine->description ?? '-' }}</p>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header">Остатки по аптекам</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Аптека</th>
                        <th>Количество</th>
                        <th>Минимум</th>
                        <th class="pe-3">Статус</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($medicine->inventoryItems as $item)
                    <tr>
                        <td class="ps-3">{{ $item->pharmacy?->name ?? '-' }}</td>
                        <td>{{ $item->quantity }} {{ $medicine->unit }}</td>
                        <td>{{ $item->minimum_quantity }} {{ $medicine->unit }}</td>
                        <td class="pe-3">{{ $item->isLowStock() ? 'Мало' : 'Достаточно' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-4 text-muted">Остатков пока нет</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
