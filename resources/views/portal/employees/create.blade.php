@extends('layouts.app')

@section('title', 'Создать сотрудника')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('employees.index') }}" class="text-decoration-none">Сотрудники</a></li>
    <li class="breadcrumb-item active">Создать</li>
@endsection

@section('content')
<div class="page-header">
    <h1>Создать сотрудника</h1>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('employees.store') }}">
            @csrf
            @include('portal.employees._form')
            <button class="btn btn-primary">Сохранить</button>
            <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">Отмена</a>
        </form>
    </div>
</div>
@endsection
