@extends('adminlte::page')

@section('title', 'Produtos')

@section('content_header')
    <x-title-with-breadcrumbs title="Editando produto <strong>{{ $product->name }}</strong>">
        {{ Breadcrumbs::render('system.products.edit', $product) }}
    </x-title-with-breadcrumbs>
@stop

@section('content')
    <x-page-card>
        <x-alerts />
        @include('system.products._form', ['url' => route('system.products.update', $product)])
    </x-page-card>
@endsection