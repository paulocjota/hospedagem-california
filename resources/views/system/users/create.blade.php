@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
    <x-title-with-breadcrumbs title="Adicionar novo usuário">
        {{ Breadcrumbs::render('system.users.create') }}
    </x-title-with-breadcrumbs>
@stop

@section('content')
    <x-page-card>
        <x-alerts />
        @include('system.users._form', ['url' => route('system.users.store')])
    </x-page-card>
@endsection