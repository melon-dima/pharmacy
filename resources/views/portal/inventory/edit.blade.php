@extends('layouts.app')

@section('title', 'Редактировать остаток')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}" class="text-decoration-none">Учет лекарств</a></li>
    <li class="breadcrumb-item active">Редактировать</li>
@endsection

@section('content')
<div class="page-header">
    <h1>Редактировать остаток</h1>
    <div class="subtitle">{{ $item->medicine?->name }} - {{ $item->pharmacy?->name }}</div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('inventory.update', $item) }}">
            @csrf
            @method('PUT')
            @include('portal.inventory._form')
            <button class="btn btn-primary">Сохранить</button>
            <a href="{{ route('inventory.index') }}" class="btn btn-outline-secondary">Отмена</a>
        </form>
    </div>
</div>
@endsection
