@extends('adminlte::page')

@section('title', 'Cadastrar entrada')

@section('content_header')
    <x-title-with-breadcrumbs title="Cadastrar entrada">
        {{ Breadcrumbs::render('system.entries.create', $room) }}
    </x-title-with-breadcrumbs>
@stop

@section('content')
    <x-page-card>
        <x-alerts />
        @include('system.entries._form', ['url' => route('system.entries.store', ['room' => $room])])
    </x-page-card>
@endsection