@props([
    'dotName' => bracket_to_dot($attributes->get('name')),
    'label' => null,
    'helpText' => null,
    'value' => 0,
])

<div class="custom-control custom-checkbox mb-4" x-data="">
    <input type="checkbox" x-on:click="$el.checked ? $refs.hidden.value='1' : $refs.hidden.value='0'"
        @if(old($dotName, $value) === 1 || old($dotName, $value) === '1')
            checked="checked"
        @endif

        {{ $attributes->merge([
            'type' => 'text',
            'class' => 'custom-control-input' . ($errors->has($dotName) ? ' is-invalid' : ''),
        ]) }}
    >
    <x-label :text="$label" :for="$attributes->get('id')" class="custom-control-label" />
    <x-invalid-feedback :name="$attributes->get('name')" />
    <x-help-text :text="$helpText" />

    <input type="hidden" name="{{ $attributes->get('name') }}" value="{{ old($dotName, $value) }}" x-ref="hidden" />
</div>