@extends('layouts.app')

@section('title', 'Добавить лекарство')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('medicines.index') }}" class="text-decoration-none">Каталог лекарств</a></li>
    <li class="breadcrumb-item active">Добавить</li>
@endsection

@section('content')
<div class="page-header">
    <h1>Добавить лекарство</h1>
    <div class="subtitle">Карточка товара для внутреннего и мобильного каталога</div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('medicines.store') }}">
            @csrf
            @include('portal.medicines._form')
            <button class="btn btn-primary">Сохранить</button>
            <a href="{{ route('medicines.index') }}" class="btn btn-outline-secondary">Отмена</a>
        </form>
    </div>
</div>
@endsection
