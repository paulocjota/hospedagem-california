@extends('adminlte::page')

@section('title', 'Produtos')

@section('content_header')
    <x-title-with-breadcrumbs title="Adicionar novo produto">
        {{ Breadcrumbs::render('system.products.create') }}
    </x-title-with-breadcrumbs>
@stop

@section('content')
    <x-page-card>
        <x-alerts />
        @include('system.products._form', ['url' => route('system.products.store')])
    </x-page-card>
@endsection