@extends('adminlte::page')

@section('title', 'Quartos')

@section('content_header')
    <x-title-with-breadcrumbs title="Alterar preço da hora adicional de todos os quartos">
        {{ Breadcrumbs::render('system.rooms.edit-price-per-additional-hour') }}
    </x-title-with-breadcrumbs>
@stop

@section('content')
    <x-page-card>
        <x-alerts />
        <form action="{{ route('system.rooms.update-price-per-additional-hour') }}" method="post">
            @csrf
            @method('PUT')

            <x-input.money.brl label="Preço por hora adicional" name="price_per_additional_hour"  id="room_price_per_additional_hour" />

            <span class="text-danger text-bold">Atenção: O preço da hora adicional de TODOS os quartos serão alterados. A mudança não afetará as entradas já criadas</span>

            <x-action-bar>
                <x-slot:right>
                    <x-button.submit class="mr-2" />
                    {{-- <x-button.back :href="route('system.rooms.index')" /> --}}
                </x-slot:right>
            </x-action-bar>
        </form>
    </x-page-card>
@endsection