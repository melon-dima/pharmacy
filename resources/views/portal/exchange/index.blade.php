@extends('layouts.app')

@section('title', 'Обмены с 1С')

@section('breadcrumb')
    <li class="breadcrumb-item active">Обмены с 1С</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-2">
    <div>
        <h1>Обмены с 1С</h1>
        <div class="subtitle">Журнал синхронизаций интеграции</div>
    </div>
    <a href="{{ route('exchange.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Добавить
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Система</th>
                        <th>Направление</th>
                        <th>Статус</th>
                        <th>Время обмена</th>
                        <th class="pe-3 text-end">Действия</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($exchanges as $exchange)
                    <tr>
                        <td class="ps-3">{{ $exchange->system }}</td>
                        <td>{{ $exchange->direction }}</td>
                        <td>{{ $exchange->status }}</td>
                        <td>{{ $exchange->exchanged_at?->format('d.m.Y H:i') ?? '-' }}</td>
                        <td class="pe-3 text-end">
                            <a href="{{ route('exchange.show', $exchange) }}" class="btn btn-sm btn-outline-secondary">Просмотр</a>
                            <a href="{{ route('exchange.edit', $exchange) }}" class="btn btn-sm btn-outline-primary">Редактировать</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-4 text-muted">Пока нет обменов</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $exchanges->links() }}
</div>
@endsection
