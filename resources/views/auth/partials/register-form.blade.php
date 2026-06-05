@if ($errors->any())
    <div class="alert alert-danger py-2">
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('register.store') }}">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Имя</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control" required autofocus>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Пароль</label>
        <input id="password" type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
        <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">Создать аккаунт</button>
</form>

<div class="mt-3 text-center">
    <a href="{{ route('login') }}" class="text-decoration-none">Уже есть аккаунт? Войти</a>
</div>
