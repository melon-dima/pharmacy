@if ($errors->any())
    <div class="alert alert-danger py-2">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ route('login.attempt') }}">
    @csrf

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Пароль</label>
        <input id="password" type="password" name="password" class="form-control" required>
    </div>

    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
        <label class="form-check-label" for="remember">
            Запомнить меня
        </label>
    </div>

    <button type="submit" class="btn btn-primary w-100">Войти</button>
</form>

<div class="mt-3 text-center">
    <a href="{{ route('register') }}" class="text-decoration-none">Нет аккаунта? Регистрация</a>
</div>
