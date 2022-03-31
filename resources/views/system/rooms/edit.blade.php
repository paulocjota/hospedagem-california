@extends('adminlte::page')

@section('title', 'Quartos')

@section('content_header')
    <x-title-with-breadcrumbs title="Editando quarto <strong>{{ $room->number }}</strong>">
        {{ Breadcrumbs::render('system.rooms.edit', $room) }}
    </x-title-with-breadcrumbs>
@stop

@section('content')
    <x-page-card>
        <x-alerts />
        @include('system.rooms._form', ['url' => route('system.rooms.update', $room)])
    </x-page-card>
@endsection