@extends('layouts.app')

@section('title', 'Создать заявку')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('requests.index') }}" class="text-decoration-none">Заявки</a></li>
    <li class="breadcrumb-item active">Создать</li>
@endsection

@section('content')
<div class="page-header">
    <h1>Создать заявку</h1>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('requests.store') }}">
            @csrf
            @include('portal.requests._form')
            <button class="btn btn-primary">Сохранить</button>
            <a href="{{ route('requests.index') }}" class="btn btn-outline-secondary">Отмена</a>
        </form>
    </div>
</div>
@endsection
