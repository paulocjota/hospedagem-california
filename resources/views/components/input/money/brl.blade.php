@props([
    'dotName' => bracket_to_dot($attributes->get('name')),
    'label' => null,
    'helpText' => null,
    'value' => null,
    'options' => [
        'precision' => 2,
        'separator' => ',',
        'delimiter' => '.',
        'unit'      => 'R$',
        'zeroCents' => false,
    ],
])

<div class="form-group">
    <x-label :text="$label" :for="$attributes->get('id')" />

    <input value="{{ old($dotName, $value ?? '') }}"

        {{ $attributes->merge([
            'type' => 'text',
            'class' => 'form-control' . ($errors->has($dotName) ? ' is-invalid' : ''),
        ]) }}

        x-init="VMasker($el).maskMoney({{ json_encode($options) }});"
    >

    <x-invalid-feedback :name="$attributes->get('name')" />
    <x-help-text :text="$helpText" />
</div>

@push('css')
    @once
        <script src="//unpkg.com/vanilla-masker@1.1.1/build/vanilla-masker.min.js"></script>
    @endonce
@endpush