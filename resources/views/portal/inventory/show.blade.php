@extends('layouts.app')

@section('title', 'Карточка остатка')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}" class="text-decoration-none">Учет лекарств</a></li>
    <li class="breadcrumb-item active">Просмотр</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-start gap-2">
    <div>
        <h1>{{ $item->medicine?->name }}</h1>
        <div class="subtitle">{{ $item->pharmacy?->name }}</div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('inventory.edit', $item) }}" class="btn btn-outline-primary btn-sm">Редактировать</a>
        <a href="{{ route('inventory.index') }}" class="btn btn-outline-secondary btn-sm">Назад</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <p><strong>Аптека:</strong> {{ $item->pharmacy?->name ?? '-' }}</p>
        <p><strong>Лекарство:</strong> {{ $item->medicine?->name ?? '-' }}</p>
        <p><strong>Код:</strong> {{ $item->medicine?->sku ?? '-' }}</p>
        <p><strong>Производитель:</strong> {{ $item->medicine?->manufacturer ?? '-' }}</p>
        <p><strong>Количество:</strong> {{ $item->quantity }} {{ $item->medicine?->unit }}</p>
        <p><strong>Минимальный остаток:</strong> {{ $item->minimum_quantity }} {{ $item->medicine?->unit }}</p>
        <p><strong>Годен до:</strong> {{ $item->expires_on?->format('d.m.Y') ?? '-' }}</p>
        <p><strong>Статус:</strong> {{ $item->isLowStock() ? 'Мало' : 'Достаточно' }}</p>
        <p class="mb-0"><strong>Примечание:</strong> {{ $item->notes ?? '-' }}</p>
    </div>
</div>
@endsection
