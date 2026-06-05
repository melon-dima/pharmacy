@extends('layouts.app')

@section('title', 'Редактировать смену')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('schedules.index') }}" class="text-decoration-none">Графики смен</a></li>
    <li class="breadcrumb-item active">Редактировать</li>
@endsection

@section('content')
<div class="page-header">
    <h1>Редактировать смену</h1>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('schedules.update', $shift) }}">
            @csrf
            @method('PUT')
            @include('portal.schedules._form')
            <button class="btn btn-primary">Сохранить</button>
            <a href="{{ route('schedules.index') }}" class="btn btn-outline-secondary">Отмена</a>
        </form>
    </div>
</div>
@endsection
