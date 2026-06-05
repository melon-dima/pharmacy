@extends('layouts.app')

@section('title', 'Чек-листы')

@section('breadcrumb')
    <li class="breadcrumb-item active">Чек-листы</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-2">
    <div>
        <h1>Чек-листы</h1>
        <div class="subtitle">Шаблоны операционных проверок</div>
    </div>
    <a href="{{ route('checklists.create') }}" class="btn btn-primary btn-sm">
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
                        <th>Аптека</th>
                        <th>Периодичность</th>
                        <th>Пунктов</th>
                        <th>Статус</th>
                        <th class="pe-3 text-end">Действия</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($checklists as $checklist)
                    <tr>
                        <td class="ps-3">{{ $checklist->title }}</td>
                        <td>{{ $checklist->pharmacy?->name ?? 'Все аптеки' }}</td>
                        <td>{{ $checklist->frequency }}</td>
                        <td>{{ $checklist->items_count }}</td>
                        <td>{{ $checklist->is_active ? 'Активен' : 'Выключен' }}</td>
                        <td class="pe-3 text-end">
                            <a href="{{ route('checklists.show', $checklist) }}" class="btn btn-sm btn-outline-secondary">Просмотр</a>
                            <a href="{{ route('checklists.edit', $checklist) }}" class="btn btn-sm btn-outline-primary">Редактировать</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">Пока нет чек-листов</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $checklists->links() }}
</div>
@endsection
