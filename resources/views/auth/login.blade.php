@extends('auth.layout')

@section('title', 'Вход')
@section('heading', 'Вход в систему')

@section('form')
    @include('auth.partials.login-form')
@endsection
