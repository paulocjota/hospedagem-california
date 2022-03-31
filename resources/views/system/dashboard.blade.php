@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <x-title-with-breadcrumbs title="Dashboard">
        {{ Breadcrumbs::render('system.dashboard') }}
    </x-title-with-breadcrumbs>
@stop

@section('content')

<x-page-card size="xl">
    <x-slot:header>Quartos</x-slot>
    <x-alerts />
    <div class="container">
        <div class="row">
            @foreach ($rooms as $room)
                <x-custom.entries.room-card :room_id="$room->id" :room_number="$room->number" />
            @endforeach
        </div>
    </div>
</x-page-card>

<h4>Informações</h4>

<div class="container-fluid">
    <div class="row">

        @if($products->count() > 0)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Produtos com estoque baixo</h3>
                    </div>

                    <div class="card-body">
                        <div class="callout callout-danger">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Quantidade</th>
                                        <th>Produto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $product)
                                        <tr>
                                            <td>{{ $product->quantity }}</td>
                                            <td>{{ $product->name }}</td>
                                        </tr>
                                    @empty

                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

    </div>
</div>
@stop

@push('css')
<script>
    let first = -1;

    function getRooms(){
        let xhr = new XMLHttpRequest();

        xhr.open('GET', @json(route('system.internal.get-roms')), true);
        xhr.send();

        xhr.addEventListener('readystatechange', function(){
            if(xhr.readyState === 4 && xhr.status === 200){
                let data = JSON.parse(xhr.responseText);
                console.log(data);

                data.forEach(function(row){
                    let latest_entry = null;

                    if(row.latest_entry){
                        latest_entry = {
                            id: row.latest_entry.id,
                            overnight: row.latest_entry.overnight,
                            entry_time: row.latest_entry.entry_time,
                            expected_exit_time: row.latest_entry.expected_exit_time,
                            expected_exit_time_with_addition: row.latest_entry.expected_exit_time_with_addition,
                            remaining_time: row.latest_entry.remaining_time
                        };
                    }

                    window.dispatchEvent(new CustomEvent('notify-' + row.id, {
                        detail: {
                            occupied: row.occupied,
                            selected: row.selected,
                            latest_entry: latest_entry
                        }
                    }))
                });

                first += 1;
                setTimeout(getRooms, first ? 3000 : 200);
            }
        }.bind(this), false);
    }

    getRooms();
</script>
@endpush