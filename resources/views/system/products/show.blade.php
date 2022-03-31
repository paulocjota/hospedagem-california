@extends('adminlte::page')

@section('title', 'Quartos')

@section('content_header')
    <x-title-with-breadcrumbs title="Visualizando produto <strong>{{ $product->name }}</strong>">
        {{ Breadcrumbs::render('system.products.show', $product) }}
    </x-title-with-breadcrumbs>
@stop

@section('content')
    <x-page-card>
        <x-alerts />

        <x-action-bar>
            <x-slot:right>
                <x-button.back :href="route('system.products.index')" />
            </x-slot>
        </x-action-bar>

        <div class="table-responsive">
            <table class="table">
                <tbody>
                    @if($product->photo)
                        <tr>
                            <th>
                                <img src="{{ route('file-server.product', $product->photo) }}"
                                    style="width: 250px; height: 250px; display: block; object-fit: contain;" class="mb-2"
                                >
                            </th>
                            <td></td>
                        </tr>
                    @endif
                    <tr>
                        <th>Nome</th>
                        <td>{{ $product->name }}</td>
                    </tr>
                    <tr>
                        <th>Preço</th>
                        <td>R$ @decToBrl($product->price)</td>
                    </tr>
                    <tr>
                        <th>Quantidade em estoque</th>
                        <td>{{ $product->quantity }}</td>
                    </tr>
                    <tr>
                        <th>Quantidade baixa</th>
                        <td>{{ $product->quantity_low ?? 'Não monitorado' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </x-page-card>
@endsection