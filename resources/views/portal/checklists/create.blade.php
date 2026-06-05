@extends('layouts.app')

@section('title', 'Создать чек-лист')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('checklists.index') }}" class="text-decoration-none">Чек-листы</a></li>
    <li class="breadcrumb-item active">Создать</li>
@endsection

@section('content')
<div class="page-header">
    <h1>Создать чек-лист</h1>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('checklists.store') }}">
            @csrf
            @include('portal.checklists._form')
            <button class="btn btn-primary">Сохранить</button>
            <a href="{{ route('checklists.index') }}" class="btn btn-outline-secondary">Отмена</a>
        </form>
    </div>
</div>
@endsection
