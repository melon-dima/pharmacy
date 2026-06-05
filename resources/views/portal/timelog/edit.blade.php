@extends('layouts.app')

@section('title', 'Редактировать запись времени')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('timelog.index') }}" class="text-decoration-none">Учёт времени</a></li>
    <li class="breadcrumb-item active">Редактировать</li>
@endsection

@section('content')
<div class="page-header">
    <h1>Редактировать запись времени</h1>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('timelog.update', $timelog) }}">
            @csrf
            @method('PUT')
            @include('portal.timelog._form')
            <button class="btn btn-primary">Сохранить</button>
            <a href="{{ route('timelog.index') }}" class="btn btn-outline-secondary">Отмена</a>
        </form>
    </div>
</div>
@endsection
