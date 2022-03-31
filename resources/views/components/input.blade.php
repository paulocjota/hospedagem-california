@props([
    'dotName' => bracket_to_dot($attributes->get('name')),
    'label' => null,
    'helpText' => null,
    'value' => null,
])

<div class="form-group">
    <x-label :text="$label" :for="$attributes->get('id')" />

    <input value="{{ old($dotName, $value ?? '') }}"

        {{ $attributes->merge([
            'type' => 'text',
            'class' => 'form-control' . ($errors->has($dotName) ? ' is-invalid' : ''),
        ]) }}
    >

    <x-invalid-feedback :name="$attributes->get('name')" />
    <x-help-text :text="$helpText" />
</div>