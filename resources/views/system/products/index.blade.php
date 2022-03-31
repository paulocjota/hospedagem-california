@extends('adminlte::page')

@section('title', 'Produtos')

@section('content_header')
    <x-title-with-breadcrumbs title="Produtos">
        {{ Breadcrumbs::render('system.products.index') }}
    </x-title-with-breadcrumbs>
@stop

@section('content')
    <x-page-card>
        <x-alerts />

        <x-action-bar>
            <x-slot:right>
                <a class="btn btn-info mr-2" href="{{ route('system.products.print-price-list') }}" target="_blank" role="button">
                    <i class="fas fa-print"></i>
                    Imprimir lista de preços
                </a>

                @can('create products', App\Models\Product::class)
                    <a class="btn btn-primary" href="{{ route('system.products.create') }}" role="button">Adicionar produto</a>
                @endcan
            </x-slot>
        </x-action-bar>

        <x-search-bar :action="route('system.products.index')" />

        <div class="table-responsive table-striped">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Foto</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Preço</th>
                        <th scope="col">Quantidade em estoque</th>
                        <th scope="col">Quantidade baixa</th>
                        <th scope="col"></th>
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
                                            style="width: 100px; height: 100px;object-fit: contain;"
                                        />
                                    </a>
                                @else
                                    <div style="width: 100px; height: 100px;" class="w-100 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-image fa-3x" style="color: #cbd5e1"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>R$ @decToBrl($product->price)</td>
                            <td>{{ $product->quantity }}</td>
                            <td>{{ $product->quantity_low ?? 'Não monitorado' }}</td>
                            <td>
                                <x-table.action-wrapper>

                                    @can('delete products', $product)
                                        <x-table.button.delete
                                            target="#modal-delete-product"
                                            title="Excluir produto"
                                            text="Deseja realmente excluir o produto {{ $product->name }}?"
                                            :route="route('system.products.destroy', $product->id)"
                                        />
                                    @endcan

                                    @can('edit products', $product)
                                        <x-table.button.edit :href="route('system.products.edit', $product->id)" />
                                    @endcan

                                    @can('view products', $product)
                                        <x-table.button.show :href="route('system.products.show', $product->id)" />
                                    @endcan
                                </x-table.action-wrapper>
                            </td>
                        </tr>
                    @empty
                        <x-table.no-rows />
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-page-card>

    <x-modal.delete id="modal-delete-product" />
    <x-modal.image id="modal-image-product" />
@endsection