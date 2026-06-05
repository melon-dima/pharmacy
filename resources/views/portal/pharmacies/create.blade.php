@extends('layouts.app')

@section('title', 'Создать аптеку')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('pharmacies.index') }}" class="text-decoration-none">Аптеки</a></li>
    <li class="breadcrumb-item active">Создать</li>
@endsection

@section('content')
<div class="page-header">
    <h1>Создать аптеку</h1>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('pharmacies.store') }}">
            @csrf
            @include('portal.pharmacies._form')
            <button class="btn btn-primary">Сохранить</button>
            <a href="{{ route('pharmacies.index') }}" class="btn btn-outline-secondary">Отмена</a>
        </form>
    </div>
</div>
@endsection
