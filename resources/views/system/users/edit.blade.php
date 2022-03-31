@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
    <x-title-with-breadcrumbs title="Editando usuário <strong>{{ $user->name }}</strong>">
        {{ Breadcrumbs::render('system.users.edit', $user) }}
    </x-title-with-breadcrumbs>
@stop

@section('content')
    <x-page-card>
        <x-alerts />
        @include('system.users._form', ['url' => route('system.users.update', $user)])
    </x-page-card>
@endsection