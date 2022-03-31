@extends('adminlte::page')

@section('title', 'Quartos')

@section('content_header')
    <x-title-with-breadcrumbs title="Adicionar novo quarto">
        {{ Breadcrumbs::render('system.rooms.create') }}
    </x-title-with-breadcrumbs>
@stop

@section('content')
    <x-page-card>
        <x-alerts />
        @include('system.rooms._form', ['url' => route('system.rooms.store')])
    </x-page-card>
@endsection