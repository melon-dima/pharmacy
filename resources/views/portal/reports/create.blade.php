@extends('layouts.app')

@section('title', 'Создать отчёт')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('reports.index') }}" class="text-decoration-none">Отчёты</a></li>
    <li class="breadcrumb-item active">Создать</li>
@endsection

@section('content')
<div class="page-header">
    <h1>Создать отчёт</h1>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('reports.store') }}">
            @csrf
            @include('portal.reports._form')
            <button class="btn btn-primary">Сохранить</button>
            <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary">Отмена</a>
        </form>
    </div>
</div>
@endsection
