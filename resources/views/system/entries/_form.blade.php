<x-debug.errors />

<form action="{{ $url }}" method="post">
    @csrf

    <div class="row">
        <div class="col-12 col-sm-6">
            <x-input :value="$room->number ?? $entry->room->number" label="Quarto" name="number" readonly />
        </div>
        <div class="col-12 col-sm-6">
            <x-input label="Placa" name="license_plate" :value="$entry->license_plate" />
        </div>
    </div>

    @if($entry->id !== null)
        @method('PUT')

        <div class="row">
            <div class="col-12 col-sm-6">
                <x-input :value="datetime_to_br($entry->entry_time)" label="Horário de entrada" name="number" readonly />
            </div>
            <div class="col-12 col-sm-6">
                <x-input :value="datetime_to_br($entry->overnight ? $entry->expected_exit_time : $entry->expected_exit_time_with_addition)" label="Horário esperado para saída" name="number" readonly />
            </div>
        </div>
    @endif

    <input type="hidden" name="room_id" value="{{ $room->id ?? $entry->room_id }}">

    @if($entry->id === null)
        <x-input.checkbox label="Pernoite" name="overnight" id="overnight" id="room_overnight" :value="$entry->overnight" />
    @endif

    @if($entry->id !== null)
        <x-custom.entries.total :entryId="$entry->id" />
    @endif

    <x-action-bar>
        <x-slot:right>
            @if($entry->id !== null)
                <x-custom.entries.modal.finish.button.delete
                    class="mr-2"
                    target="#modal-finish-entry"
                    title="Finalizar entrada"
                    text="Deseja realmente finalizar a entrada de {{ datetime_to_br($entry->entry_time) }}?"
                    :route="route('system.entries.finish', $entry->id)"
                />
            @endif
            <x-button.submit class="mr-2" />
            <x-button.back :href="route('system.dashboard')" />
        </x-slot:right>
    </x-action-bar>
</form>

<x-modal.xhr.delete id="modal-delete-product" eventName="reload-products" />
<x-custom.entries.modal.finish id="modal-finish-entry" />