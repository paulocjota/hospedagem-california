@extends('adminlte::page')

@section('title', 'Quartos')

@section('content_header')
    <x-title-with-breadcrumbs title="Quartos">
        {{ Breadcrumbs::render('system.rooms.index') }}
    </x-title-with-breadcrumbs>
@stop

@section('content')
    <x-page-card>
        <x-alerts />

        <x-action-bar>
            <x-slot:right>
                @can('create rooms')
                    <a class="btn btn-primary" href="{{ route('system.rooms.create') }}" role="button">Adicionar quarto</a>
                @endcan
            </x-slot>
        </x-action-bar>

        <x-search-bar :action="route('system.rooms.index')" />

        <div class="table-responsive table-striped">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Número</th>
                        <th scope="col">Preço</th>
                        <th scope="col">Preço por hora adicional</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rooms as $room)
                        <tr>
                            <td>{{ $room->number }}</td>
                            <td>R$ @decToBrl($room->price)</td>
                            <td>R$ @decToBrl($room->price_per_additional_hour)</td>
                            <td>
                                <x-table.action-wrapper>

                                    @can('delete rooms', $room)
                                        <x-table.button.delete
                                            target="#modal-delete-room"
                                            title="Excluir quarto"
                                            text="Deseja realmente excluir o quarto {{ $room->number }}?"
                                            :route="route('system.rooms.destroy', $room->id)"
                                        />
                                    @endcan

                                    @can('edit rooms', $room)
                                    <x-table.button.edit :href="route('system.rooms.edit', $room->id)" />
                                    @endcan

                                    @can('view rooms', $room)
                                        <x-table.button.show :href="route('system.rooms.show', $room->id)" />
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

    <x-modal.delete id="modal-delete-room" />
@endsection