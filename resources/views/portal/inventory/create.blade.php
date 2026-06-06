@extends('layouts.app')

@section('title', 'Добавить лекарство в учет')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}" class="text-decoration-none">Учет лекарств</a></li>
    <li class="breadcrumb-item active">Добавить</li>
@endsection

@section('content')
<div class="page-header">
    <h1>Добавить лекарство в учет</h1>
    <div class="subtitle">Создание остатка лекарства в выбранной аптеке</div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('inventory.store') }}">
            @csrf
            @include('portal.inventory._form')
            <button class="btn btn-primary">Сохранить</button>
            <a href="{{ route('inventory.index') }}" class="btn btn-outline-secondary">Отмена</a>
        </form>
    </div>
</div>
@endsection
