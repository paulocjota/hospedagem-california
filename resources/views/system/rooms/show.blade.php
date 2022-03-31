@extends('adminlte::page')

@section('title', 'Quartos')

@section('content_header')
    <x-title-with-breadcrumbs title="Visualizando quarto <strong>{{ $room->number }}</strong>">
        {{ Breadcrumbs::render('system.rooms.show', $room) }}
    </x-title-with-breadcrumbs>
@stop

@section('content')
    <x-page-card>
        <x-alerts />

        <x-action-bar>
            <x-slot:right>
                <x-button.back :href="route('system.rooms.index')" />
            </x-slot>
        </x-action-bar>

        <table class="table">
            <tbody>
                <tr>
                    <th>Número</th>
                    <td>{{ $room->number }}</td>
                </tr>
                <tr>
                    <th>Preço</th>
                    <td>R$ @decToBrl($room->price)</td>
                </tr>
                <tr>
                    <th>Preço por hora adicional</th>
                    <td>R$ @decToBrl($room->price_per_additional_hour)</td>
                </tr>
                <tr>
                    <th>Ocupado</th>
                    <td>
                        <x-input.checkbox label=" " name="occupied" :value="$room->occupied" />
                    </td>
                </tr>
            </tbody>
        </table>
    </x-page-card>
@endsection