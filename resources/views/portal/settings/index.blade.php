@extends('layouts.app')

@section('title', 'Настройки')

@section('breadcrumb')
    <li class="breadcrumb-item active">Настройки</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-2">
    <div>
        <h1>Настройки</h1>
        <div class="subtitle">Системные параметры портала</div>
    </div>
    <a href="{{ route('settings.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Добавить
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Группа</th>
                        <th>Ключ</th>
                        <th>Значение</th>
                        <th>Описание</th>
                        <th class="pe-3 text-end">Действия</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($settings as $setting)
                    <tr>
                        <td class="ps-3">{{ $setting->group ?? '-' }}</td>
                        <td>{{ $setting->key }}</td>
                        <td>{{ $setting->value ?? '-' }}</td>
                        <td>{{ $setting->description ?? '-' }}</td>
                        <td class="pe-3 text-end">
                            <a href="{{ route('settings.show', $setting) }}" class="btn btn-sm btn-outline-secondary">Просмотр</a>
                            <a href="{{ route('settings.edit', $setting) }}" class="btn btn-sm btn-outline-primary">Редактировать</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-4 text-muted">Пока нет настроек</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $settings->links() }}
</div>
@endsection
