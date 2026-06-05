<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<header class="border-bottom bg-white">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand fw-semibold d-flex align-items-center gap-2" href="{{ url('/') }}">
                <span class="badge text-bg-primary rounded-pill px-3 py-2">PH</span>
                <span>Аптечная сеть</span>
            </a>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('dashboard') }}" class="text-decoration-none text-secondary">Портал</a>
                <a href="{{ route('login') }}" class="text-decoration-none">Вход</a>
            </div>
        </div>
    </nav>
</header>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-7 col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    <h1 class="h4 mb-3">@yield('heading')</h1>

                    @yield('form')
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
