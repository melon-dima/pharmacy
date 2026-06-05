@extends('layouts.app')

@section('title', 'Редактировать чек-лист')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('checklists.index') }}" class="text-decoration-none">Чек-листы</a></li>
    <li class="breadcrumb-item active">Редактировать</li>
@endsection

@section('content')
<div class="page-header">
    <h1>Редактировать чек-лист</h1>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('checklists.update', $checklist) }}">
            @csrf
            @method('PUT')
            @include('portal.checklists._form')
            <button class="btn btn-primary">Сохранить</button>
            <a href="{{ route('checklists.index') }}" class="btn btn-outline-secondary">Отмена</a>
        </form>
    </div>
</div>
@endsection
