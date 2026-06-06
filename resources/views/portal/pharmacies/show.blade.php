@extends('layouts.app')

@section('title', 'Просмотр аптеки')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('pharmacies.index') }}" class="text-decoration-none">Аптеки</a></li>
    <li class="breadcrumb-item active">Просмотр</li>
<div class="card mt-3">
    <div class="card-header">Остатки лекарств</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Лекарство</th>
                        <th>Код</th>
                        <th>Количество</th>
                        <th>Минимум</th>
                        <th class="pe-3">Статус</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($pharmacy->inventoryItems as $item)
                    <tr>
                        <td class="ps-3">{{ $item->medicine?->name ?? '-' }}</td>
                        <td>{{ $item->medicine?->sku ?? '-' }}</td>
                        <td>{{ $item->quantity }} {{ $item->medicine?->unit }}</td>
                        <td>{{ $item->minimum_quantity }} {{ $item->medicine?->unit }}</td>
                        <td class="pe-3">{{ $item->isLowStock() ? 'Мало' : 'Достаточно' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-4 text-muted">В аптеке пока нет лекарств в учете</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-start gap-2">
    <div><h1>{{ $pharmacy->name }}</h1></div>
    <div class="d-flex gap-2">
        <a href="{{ route('pharmacies.edit', $pharmacy) }}" class="btn btn-outline-primary btn-sm">Редактировать</a>
        <a href="{{ route('pharmacies.index') }}" class="btn btn-outline-secondary btn-sm">Назад</a>
    </div>
</div>
<div class="card"><div class="card-body">
    <p><strong>Код:</strong> {{ $pharmacy->code ?? '-' }}</p>
    <p><strong>Адрес:</strong> {{ $pharmacy->address ?? '-' }}</p>
    <p><strong>Телефон:</strong> {{ $pharmacy->phone ?? '-' }}</p>
    <p><strong>Сотрудники:</strong> {{ $pharmacy->employees->count() }}</p>
    <p><strong>Смены:</strong> {{ $pharmacy->shifts->count() }}</p>
    <p><strong>Чек-листы:</strong> {{ $pharmacy->checklists->count() }}</p>
    <p class="mb-0"><strong>Статус:</strong> {{ $pharmacy->is_active ? 'Активна' : 'Неактивна' }}</p>
</div></div>
@endsection
