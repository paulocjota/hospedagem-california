@extends('adminlte::page')

@section('title', 'Editar entrada')

@section('content_header')
    <x-title-with-breadcrumbs title="Editar entrada">
        {{ Breadcrumbs::render('system.entries.edit', $entry) }}
    </x-title-with-breadcrumbs>
@stop

@section('content')
    <x-page-card>
        <x-alerts />
        @include('system.entries._form', ['url' => route('system.entries.update', $entry)])
    </x-page-card>
@endsection