<form action="{{ $url }}" method="post">
    @csrf

    @if($room->id !== null)
        @method('PUT')
    @endif

    <x-input label="Número" name="number" id="room_number" :value="$room->number" />
    <x-input.money.brl label="Preço" name="price" id="room_price" :value="$room->price" />
    <x-input.money.brl label="Preço por hora adicional" name="price_per_additional_hour"  id="room_price_per_additional_hour" :value="$room->price_per_additional_hour" />
    <x-input.checkbox label="Ocupado" name="occupied" id="occupied" id="room_occupied" :value="$room->occupied" />

    <x-action-bar>
        <x-slot:right>
            <x-button.submit class="mr-2" />
            <x-button.back :href="route('system.rooms.index')" />
        </x-slot:right>
    </x-action-bar>
</form>