@extends('layouts.app')

@section('title', 'Создать настройку')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('settings.index') }}" class="text-decoration-none">Настройки</a></li>
    <li class="breadcrumb-item active">Создать</li>
@endsection

@section('content')
<div class="page-header">
    <h1>Создать настройку</h1>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('settings.store') }}">
            @csrf
            @include('portal.settings._form')
            <button class="btn btn-primary">Сохранить</button>
            <a href="{{ route('settings.index') }}" class="btn btn-outline-secondary">Отмена</a>
        </form>
    </div>
</div>
@endsection
