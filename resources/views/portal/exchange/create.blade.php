@extends('layouts.app')

@section('title', 'Создать обмен')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('exchange.index') }}" class="text-decoration-none">Обмены с 1С</a></li>
    <li class="breadcrumb-item active">Создать</li>
@endsection

@section('content')
<div class="page-header">
    <h1>Создать запись обмена</h1>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('exchange.store') }}">
            @csrf
            @include('portal.exchange._form')
            <button class="btn btn-primary">Сохранить</button>
            <a href="{{ route('exchange.index') }}" class="btn btn-outline-secondary">Отмена</a>
        </form>
    </div>
</div>
@endsection
