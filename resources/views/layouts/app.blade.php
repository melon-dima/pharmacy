<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Портал') — Аптечная сеть</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #0a2647;
            --sidebar-hover: #144272;
            --sidebar-active: #205295;
            --topbar-height: 60px;
        }

        * { box-sizing: border-box; }

        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', system-ui, sans-serif;
            font-size: 0.9rem;
        }

        /* ── Sidebar ── */
        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            transition: transform 0.25s ease, width 0.25s ease;
            overflow-x: hidden;
        }

        #sidebar.collapsed {
            width: 64px;
        }

        .sidebar-brand {
            height: var(--topbar-height);
            padding: 0 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            flex-shrink: 0;
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar-brand .brand-logo {
            width: 34px; height: 34px;
            border-radius: 8px;
            background: #2d6dc8;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .sidebar-brand .brand-text { opacity: 1; transition: opacity 0.2s; }
        #sidebar.collapsed .brand-text { opacity: 0; pointer-events: none; }

        .sidebar-nav { flex: 1; overflow-y: auto; overflow-x: hidden; padding-bottom: 1rem; }

        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 2px; }

        .nav-section-title {
            color: rgba(255,255,255,0.35);
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 1.1rem 1rem 0.35rem;
            white-space: nowrap;
            overflow: hidden;
            transition: opacity 0.2s;
        }
        #sidebar.collapsed .nav-section-title { opacity: 0; }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 1rem;
            color: rgba(255,255,255,0.72);
            text-decoration: none;
            white-space: nowrap;
            overflow: hidden;
            transition: background 0.15s, color 0.15s;
            border-left: 3px solid transparent;
        }

        .sidebar-link .link-icon {
            font-size: 1.1rem;
            flex-shrink: 0;
            width: 20px;
            text-align: center;
        }

        .sidebar-link .link-text { transition: opacity 0.2s; }
        #sidebar.collapsed .link-text { opacity: 0; pointer-events: none; }

        .sidebar-link:hover {
            background: var(--sidebar-hover);
            color: #fff;
        }

        .sidebar-link.active {
            background: var(--sidebar-active);
            color: #fff;
            border-left-color: #4da6ff;
        }

        /* ── Main layout ── */
        #main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.25s ease;
        }

        #main-content.expanded {
            margin-left: 64px;
        }

        /* ── Topbar ── */
        #topbar {
            height: var(--topbar-height);
            background: #fff;
            border-bottom: 1px solid #e9ecef;
            position: sticky;
            top: 0;
            z-index: 1030;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            justify-content: space-between;
            gap: 1rem;
        }

        .topbar-left { display: flex; align-items: center; gap: 1rem; min-width: 0; }
        .topbar-right { display: flex; align-items: center; gap: 0.5rem; flex-shrink: 0; }

        .breadcrumb { margin-bottom: 0; font-size: 0.82rem; }
        .breadcrumb-item + .breadcrumb-item::before { color: #adb5bd; }

        .btn-toggle-sidebar {
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 6px;
            line-height: 1;
            transition: background 0.15s;
        }
        .btn-toggle-sidebar:hover { background: #f8f9fa; color: #343a40; }

        .avatar-circle {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: #0d6efd;
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.78rem;
            font-weight: 600;
            flex-shrink: 0;
        }

        /* ── Content ── */
        #content { flex: 1; padding: 1.5rem; }

        .page-header {
            margin-bottom: 1.5rem;
        }
        .page-header h1 {
            font-size: 1.35rem;
            font-weight: 600;
            margin-bottom: 0.15rem;
            color: #1a2540;
        }
        .page-header .subtitle { color: #6c757d; font-size: 0.82rem; }

        /* ── Cards ── */
        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 1px 4px rgba(0,0,0,0.07);
        }
        .card-header {
            background: transparent;
            border-bottom: 1px solid #f0f2f5;
            padding: 0.9rem 1.25rem;
            font-weight: 600;
            font-size: 0.88rem;
            color: #1a2540;
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.mobile-open { transform: translateX(0); }
            #main-content { margin-left: 0 !important; }
            #sidebar-overlay {
                display: block;
                position: fixed; inset: 0;
                background: rgba(0,0,0,0.4);
                z-index: 1039;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

<!-- Mobile overlay -->
<div id="sidebar-overlay" style="display:none" onclick="closeSidebar()"></div>

<!-- ══ Sidebar ══ -->
<aside id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-logo">
            <i class="bi bi-capsule-pill text-white" style="font-size:1rem"></i>
        </div>
        <div class="brand-text">
            <div class="text-white fw-semibold" style="font-size:0.85rem;line-height:1.3">Аптечная сеть</div>
            <div style="color:rgba(255,255,255,0.45);font-size:0.68rem">Корпоративный портал</div>
        </div>
    </div>

    <nav class="sidebar-nav pt-1">
        <div class="nav-section-title">Главное</div>
        <a href="{{ url('/dashboard') }}" class="sidebar-link {{ request()->is('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2 link-icon"></i>
            <span class="link-text">Дашборд</span>
        </a>

        <div class="nav-section-title">Рабочее время</div>
        <a href="{{ route('schedules.index') }}" class="sidebar-link {{ request()->is('schedules*') ? 'active' : '' }}">
            <i class="bi bi-calendar3 link-icon"></i>
            <span class="link-text">Графики смен</span>
        </a>
        <a href="{{ route('timelog.index') }}" class="sidebar-link {{ request()->is('timelog*') ? 'active' : '' }}">
            <i class="bi bi-clock-history link-icon"></i>
            <span class="link-text">Учёт времени</span>
        </a>

        <div class="nav-section-title">Операционный контроль</div>
        <a href="{{ route('checklists.index') }}" class="sidebar-link {{ request()->is('checklists*') ? 'active' : '' }}">
            <i class="bi bi-check2-square link-icon"></i>
            <span class="link-text">Чек-листы</span>
        </a>
                <a href="{{ route('medicines.index') }}" class="sidebar-link {{ request()->is('medicines*') ? 'active' : '' }}">
            <i class="bi bi-journal-medical link-icon"></i>
            <span class="link-text">Каталог лекарств</span>
        </a>
<a href="{{ route('inventory.index') }}" class="sidebar-link {{ request()->is('inventory*') ? 'active' : '' }}">
            <i class="bi bi-capsule link-icon"></i>
            <span class="link-text">Учет лекарств</span>
        </a>

        <div class="nav-section-title">Кадры</div>
        <a href="{{ route('pharmacies.index') }}" class="sidebar-link {{ request()->is('pharmacies*') ? 'active' : '' }}">
            <i class="bi bi-shop link-icon"></i>
            <span class="link-text">������</span>
        </a>
        <a href="{{ route('employees.index') }}" class="sidebar-link {{ request()->is('employees*') ? 'active' : '' }}">
            <i class="bi bi-people link-icon"></i>
            <span class="link-text">Сотрудники</span>
        </a>
        <a href="{{ route('requests.index') }}" class="sidebar-link {{ request()->is('requests*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text link-icon"></i>
            <span class="link-text">Заявки</span>
        </a>

        <div class="nav-section-title">Аналитика</div>
        <a href="{{ route('reports.index') }}" class="sidebar-link {{ request()->is('reports*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-line link-icon"></i>
            <span class="link-text">Отчёты</span>
        </a>
        <a href="{{ route('exchange.index') }}" class="sidebar-link {{ request()->is('exchange*') ? 'active' : '' }}">
            <i class="bi bi-arrow-left-right link-icon"></i>
            <span class="link-text">Обмены с 1С</span>
        </a>

        <div class="nav-section-title">Система</div>
        <a href="{{ route('settings.index') }}" class="sidebar-link {{ request()->is('settings*') ? 'active' : '' }}">
            <i class="bi bi-gear link-icon"></i>
            <span class="link-text">Настройки</span>
        </a>
        <a href="{{ route('users.index') }}" class="sidebar-link {{ request()->is('users*') ? 'active' : '' }}">
            <i class="bi bi-person-gear link-icon"></i>
            <span class="link-text">������������</span>
        </a>
    </nav>
</aside>

<!-- ══ Main content ══ -->
<div id="main-content">

    <!-- Topbar -->
    <header id="topbar">
        <div class="topbar-left">
            <button class="btn-toggle-sidebar" id="sidebarToggle" title="Скрыть/показать меню">
                <i class="bi bi-list" style="font-size:1.3rem"></i>
            </button>
            <nav aria-label="breadcrumb" class="d-none d-md-block">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}" class="text-decoration-none">Главная</a></li>
                    @yield('breadcrumb')
                </ol>
            </nav>
        </div>

        <div class="topbar-right">
            <button class="btn-toggle-sidebar position-relative" title="Уведомления">
                <i class="bi bi-bell" style="font-size:1.1rem"></i>
                <span class="position-absolute bg-danger rounded-circle"
                      style="width:8px;height:8px;top:2px;right:2px;border:2px solid #fff"></span>
            </button>

            <div class="dropdown">
                <button class="btn-toggle-sidebar dropdown-toggle d-flex align-items-center gap-2"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="avatar-circle">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                    </div>
                    <span class="d-none d-lg-inline" style="font-size:0.85rem;color:#343a40">
                        {{ auth()->user()->name ?? 'Пользователь' }}
                    </span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="min-width:200px;font-size:0.87rem">
                    <li class="px-3 py-2">
                        <div class="fw-semibold" style="color:#1a2540">{{ auth()->user()->name ?? 'Пользователь' }}</div>
                        <div class="text-muted" style="font-size:0.78rem">{{ auth()->user()->email ?? '' }}</div>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2 text-muted"></i>Мой профиль</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2 text-muted"></i>Настройки</a></li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        @if(Route::has('logout'))
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item text-danger" type="submit">
                                <i class="bi bi-box-arrow-right me-2"></i>Выйти
                            </button>
                        </form>
                    @else
                        <a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i>Выйти</a>
                    @endif
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Page content -->
    <main id="content">
        @yield('content')
    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const sidebar      = document.getElementById('sidebar');
    const mainContent  = document.getElementById('main-content');
    const overlay      = document.getElementById('sidebar-overlay');
    const isMobile     = () => window.innerWidth <= 768;

    document.getElementById('sidebarToggle').addEventListener('click', () => {
        if (isMobile()) {
            sidebar.classList.toggle('mobile-open');
            overlay.style.display = sidebar.classList.contains('mobile-open') ? 'block' : 'none';
        } else {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        }
    });

    function closeSidebar() {
        sidebar.classList.remove('mobile-open');
        overlay.style.display = 'none';
    }
</script>
@stack('scripts')
</body>
</html>




