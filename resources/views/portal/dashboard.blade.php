@extends('layouts.app')

@section('title', 'Дашборд')

@section('breadcrumb')
    <li class="breadcrumb-item active">Дашборд</li>
@endsection

@push('styles')
<style>
    .stat-card { border-radius: 0.75rem; border: none; box-shadow: 0 1px 4px rgba(0,0,0,0.07); }
    .stat-icon {
        width: 52px; height: 52px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    .stat-value { font-size: 1.75rem; font-weight: 700; line-height: 1.1; color: #1a2540; }
    .stat-label { font-size: 0.78rem; color: #6c757d; margin-top: 0.15rem; }
    .stat-delta { font-size: 0.78rem; }

    .widget-card { border-radius: 0.75rem; border: none; box-shadow: 0 1px 4px rgba(0,0,0,0.07); }

    .shift-badge {
        display: inline-block;
        padding: 0.2rem 0.6rem;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 500;
    }

    .checklist-row td { vertical-align: middle; }

    .activity-item {
        display: flex; gap: 0.75rem; align-items: flex-start;
        padding: 0.65rem 0;
        border-bottom: 1px solid #f0f2f5;
    }
    .activity-item:last-child { border-bottom: none; }
    .activity-dot {
        width: 8px; height: 8px; border-radius: 50%;
        flex-shrink: 0; margin-top: 5px;
    }

    .pharmacy-pill {
        display: inline-flex; align-items: center; gap: 0.4rem;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        background: #e8f0fe; color: #1a56db;
        cursor: pointer;
        border: 2px solid transparent;
        transition: border-color 0.15s;
    }
    .pharmacy-pill:hover, .pharmacy-pill.active { border-color: #1a56db; }
</style>
@endpush

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-2">
    <div>
        <h1>Добрый день, {{ auth()->user()->name ?? 'Коллега' }} 👋</h1>
        <div class="subtitle">{{ now()->isoFormat('dddd, D MMMM YYYY') }} &nbsp;·&nbsp; Сегодня на смене: <strong>42 сотрудника</strong></div>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-funnel me-1"></i>Фильтр
        </button>
        <button class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Добавить
        </button>
    </div>
</div>

<!-- ── Быстрые фильтры по аптекам ── -->
<div class="d-flex gap-2 flex-wrap mb-3">
    <span class="pharmacy-pill active"><i class="bi bi-shop"></i>Все аптеки</span>
    <span class="pharmacy-pill"><i class="bi bi-shop"></i>Аптека №1</span>
    <span class="pharmacy-pill"><i class="bi bi-shop"></i>Аптека №5</span>
    <span class="pharmacy-pill"><i class="bi bi-shop"></i>Аптека №12</span>
    <span class="pharmacy-pill"><i class="bi bi-shop"></i>Аптека №18</span>
    <span class="pharmacy-pill text-muted bg-light" style="color:#6c757d!important"><i class="bi bi-plus"></i>Ещё 9</span>
</div>

<!-- ── Метрики ── -->
<div class="row g-3 mb-3">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon bg-primary bg-opacity-10">
                    <i class="bi bi-people-fill text-primary"></i>
                </div>
                <div>
                    <div class="stat-value">42</div>
                    <div class="stat-label">Сотрудников на смене</div>
                </div>
            </div>
            <div class="stat-delta text-success mt-2">
                <i class="bi bi-arrow-up-short"></i> +3 к вчерашнему дню
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon bg-success bg-opacity-10">
                    <i class="bi bi-calendar-check-fill text-success"></i>
                </div>
                <div>
                    <div class="stat-value">14</div>
                    <div class="stat-label">Смен открыто сегодня</div>
                </div>
            </div>
            <div class="stat-delta text-muted mt-2">
                <i class="bi bi-dash-lg"></i> Как обычно
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon bg-danger bg-opacity-10">
                    <i class="bi bi-exclamation-triangle-fill text-danger"></i>
                </div>
                <div>
                    <div class="stat-value">7</div>
                    <div class="stat-label">Чек-листов просрочено</div>
                </div>
            </div>
            <div class="stat-delta text-danger mt-2">
                <i class="bi bi-arrow-up-short"></i> +2 с прошлой недели
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon bg-warning bg-opacity-10">
                    <i class="bi bi-file-earmark-check-fill text-warning"></i>
                </div>
                <div>
                    <div class="stat-value">5</div>
                    <div class="stat-label">Заявок на согласование</div>
                </div>
            </div>
            <div class="stat-delta text-warning mt-2">
                <i class="bi bi-clock"></i> Ожидают подтверждения
            </div>
        </div>
    </div>
</div>

<!-- ── Основные виджеты ── -->
<div class="row g-3 mb-3">
    <!-- График смен сегодня -->
    <div class="col-12 col-lg-7">
        <div class="card widget-card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-calendar3 me-2 text-primary"></i>Смены сегодня</span>
                <a href="#" class="text-decoration-none text-primary" style="font-size:0.8rem">Все смены →</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" style="font-size:0.83rem">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Сотрудник</th>
                                <th>Аптека</th>
                                <th>Время</th>
                                <th>Должность</th>
                                <th>Статус</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $shifts = [
                                ['Иванова А.В.',   'Аптека №1',  '08:00–20:00', 'Фармацевт',       'work',   'На смене'],
                                ['Петров С.К.',    'Аптека №5',  '08:00–20:00', 'Провизор',        'work',   'На смене'],
                                ['Сидорова Е.Н.',  'Аптека №12', '09:00–18:00', 'Зав. аптекой',    'break',  'Перерыв'],
                                ['Козлов Д.И.',    'Аптека №1',  '14:00–22:00', 'Фармацевт',       'wait',   'Ожидает'],
                                ['Морозова Л.П.',  'Аптека №18', '08:00–20:00', 'Фармацевт',       'work',   'На смене'],
                                ['Новиков А.А.',   'Аптека №5',  '20:00–08:00', 'Провизор',        'wait',   'Ожидает'],
                            ];
                            $statusClasses = [
                                'work'  => 'bg-success bg-opacity-10 text-success',
                                'break' => 'bg-warning bg-opacity-10 text-warning',
                                'wait'  => 'bg-secondary bg-opacity-10 text-secondary',
                            ];
                            @endphp
                            @foreach($shifts as $s)
                            <tr>
                                <td class="ps-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-circle" style="width:28px;height:28px;font-size:0.65rem;background:#0d6efd">
                                            {{ strtoupper(mb_substr($s[0], 0, 1)) }}
                                        </div>
                                        {{ $s[0] }}
                                    </div>
                                </td>
                                <td class="text-muted">{{ $s[1] }}</td>
                                <td>{{ $s[2] }}</td>
                                <td class="text-muted">{{ $s[3] }}</td>
                                <td>
                                    <span class="shift-badge {{ $statusClasses[$s[4]] }}">{{ $s[5] }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Правая колонка -->
    <div class="col-12 col-lg-5 d-flex flex-column gap-3">

        <!-- Просроченные чек-листы -->
        <div class="card widget-card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-exclamation-circle me-2 text-danger"></i>Просроченные чек-листы</span>
                <span class="badge bg-danger rounded-pill">7</span>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0" style="font-size:0.82rem">
                    <tbody class="checklist-row">
                        @php
                        $cls = [
                            ['Открытие аптеки',    'Аптека №12', '2 дня'],
                            ['Температурный лист', 'Аптека №5',  '1 день'],
                            ['Проверка касс',      'Аптека №1',  '3 дня'],
                            ['Инвентаризация',     'Аптека №18', '5 дней'],
                        ];
                        @endphp
                        @foreach($cls as $c)
                        <tr>
                            <td class="ps-3">
                                <div class="fw-medium">{{ $c[0] }}</div>
                                <div class="text-muted" style="font-size:0.75rem">{{ $c[1] }}</div>
                            </td>
                            <td class="text-end pe-3">
                                <span class="shift-badge bg-danger bg-opacity-10 text-danger">
                                    <i class="bi bi-clock me-1"></i>{{ $c[2] }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Заявки на согласование -->
        <div class="card widget-card flex-grow-1">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-file-earmark-text me-2 text-warning"></i>Заявки</span>
                <a href="#" class="text-decoration-none text-primary" style="font-size:0.8rem">Все →</a>
            </div>
            <div class="card-body p-3" style="font-size:0.83rem">
                @php
                $reqs = [
                    ['Иванова А.В.',  'Отпуск',     '01.06–14.06', 'warning'],
                    ['Козлов Д.И.',   'Отгул',      '28.05',       'info'],
                    ['Морозова Л.П.', 'Больничный', '25.05–',      'secondary'],
                    ['Петров С.К.',   'Отпуск',     '15.06–28.06', 'warning'],
                    ['Новиков А.А.',  'Командир.',  '02.06–04.06', 'info'],
                ];
                @endphp
                @foreach($reqs as $r)
                <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                    <div>
                        <div class="fw-medium">{{ $r[0] }}</div>
                        <div class="text-muted" style="font-size:0.75rem">{{ $r[1] }} · {{ $r[2] }}</div>
                    </div>
                    <div class="d-flex gap-1">
                        <button class="btn btn-sm btn-success" style="padding:0.15rem 0.5rem;font-size:0.75rem">
                            <i class="bi bi-check-lg"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" style="padding:0.15rem 0.5rem;font-size:0.75rem">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- ── Лента активности + Объявления ── -->
<div class="row g-3">
    <div class="col-12 col-md-6">
        <div class="card widget-card">
            <div class="card-header">
                <i class="bi bi-activity me-2 text-primary"></i>Последние события
            </div>
            <div class="card-body px-3 py-2">
                @php
                $events = [
                    ['success', 'Иванова А.В. открыла смену',               '09:03', 'Аптека №1'],
                    ['primary', 'Загружен чек-лист «Открытие»',             '09:01', 'Аптека №5'],
                    ['danger',  'Просрочен чек-лист «Температурный лист»',  '08:45', 'Аптека №12'],
                    ['warning', 'Заявка на отпуск ожидает согласования',    '08:32', 'Козлов Д.И.'],
                    ['success', 'Сидорова Е.Н. вышла на смену',             '08:58', 'Аптека №12'],
                    ['secondary','Синхронизация с 1С завершена',            '08:00', 'Авто'],
                ];
                @endphp
                @foreach($events as $e)
                <div class="activity-item">
                    <div class="activity-dot bg-{{ $e[0] }} mt-1"></div>
                    <div class="flex-grow-1">
                        <div style="font-size:0.83rem">{{ $e[1] }}</div>
                        <div class="text-muted" style="font-size:0.73rem">{{ $e[3] }} · {{ $e[2] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="card widget-card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-megaphone me-2 text-primary"></i>Объявления</span>
                <button class="btn btn-sm btn-outline-primary" style="font-size:0.75rem;padding:0.2rem 0.6rem">
                    <i class="bi bi-plus me-1"></i>Добавить
                </button>
            </div>
            <div class="card-body px-3 py-2">
                @php
                $announcements = [
                    ['danger',   'Внимание',       'Плановая проверка Роспотребнадзора 30.05. Проверьте документы и чек-листы.',   '25.05.2026'],
                    ['primary',  'Информация',     'Обновлён шаблон чек-листа «Открытие аптеки». Новые требования с 01.06.',       '24.05.2026'],
                    ['success',  'Новости',        'Обучение по работе с порталом — 28.05 в 14:00 онлайн. Ссылка в Telegram.',     '23.05.2026'],
                    ['warning',  'Кадры',          'Напоминание: сдача табелей за май до 29.05 включительно.',                     '22.05.2026'],
                ];
                @endphp
                @foreach($announcements as $a)
                <div class="p-3 rounded-3 mb-2" style="background:#f8f9fa;font-size:0.83rem">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <span class="badge bg-{{ $a[0] }} bg-opacity-10 text-{{ $a[0] }}" style="font-size:0.72rem">{{ $a[1] }}</span>
                        <span class="text-muted" style="font-size:0.72rem">{{ $a[3] }}</span>
                    </div>
                    <div>{{ $a[2] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
