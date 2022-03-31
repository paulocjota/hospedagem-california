@extends('adminlte::page')

@section('title', 'Produtos')

@section('content_header')
    <x-title-with-breadcrumbs title="Incrementar estoque">
        {{ Breadcrumbs::render('system.products.increment-quantity.index') }}
    </x-title-with-breadcrumbs>
@stop

@section('content')
    <x-page-card>
        <x-alerts />

        {{-- <x-search-bar :action="route('system.products.index')" /> --}}

        <form action="{{ route('system.products.increment-quantity') }}" method="POST">
            @csrf
            <div class="table-responsive table-hover">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Nome</th>
                            <th scope="col">Preço</th>
                            <th scope="col">em estoque</th>
                            <th scope="col">adicionar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td>
                                    @if($product->photo)
                                        <a data-toggle="modal" role="button"
                                            data-target="#modal-image-product"
                                            data-title="{{ $product->name }}"
                                            data-img="{{ route('file-server.product', $product->photo) }}"
                                        >
                                            <img src="{{ route('file-server.product', $product->photo) }}"
                                                style="width: 50px; height: 50px;object-fit: contain;"
                                            />
                                        </a>
                                    @else
                                        <div style="width: 50px; height: 50px;" class="w-100 d-flex align-items-center justify-content-center">
                                            <i class="fas fa-image fa-2x" style="color: #cbd5e1"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>R$ @decToBrl($product->price)</td>
                                <td>{{ $product->quantity }}</td>
                                <td>
                                    <x-table.action-wrapper>
                                        <input type="hidden" name="products[{{ $loop->index }}][id]" value="{{ $product->id }}" />
                                        <x-input name="products[{{ $loop->index }}][quantity]" type="number" step="1" min="0" />
                                    </x-table.action-wrapper>
                                </td>
                            </tr>
                        @empty
                            <x-table.no-rows />
                        @endforelse
                    </tbody>
                </table>
            </div>

            <x-action-bar>
                <x-slot:right>
                    <x-button.submit class="mr-2" />
                    <x-button.back :href="route('system.dashboard')" />
                </x-slot:right>
            </x-action-bar>
        </form>

    </x-page-card>

    <x-modal.image id="modal-image-product" />
@endsection