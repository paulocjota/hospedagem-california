@props([
    'dotName' => bracket_to_dot($attributes->get('name')),
    'label' => null,
    'helpText' => null,
    'value' => null,
    'options' => [ /* https://flatpickr.js.org/options/ */
        'altInput' => true,
        'altFormat' => 'd/m/Y',
        'dateFormat' => 'Y-m-d',
    ]
]){{-- 'entry_time' => ['required', 'date', 'date_format:Y-m-d'], --}}

<div class="form-group">
    <x-label :text="$label" :for="$attributes->get('id')" />

    <input value="{{ old($dotName, $value ?? '') }}"

        {{ $attributes->merge([
            'class' => 'form-control' . ($errors->has($dotName) ? ' is-invalid' : ''),
        ]) }}

        x-data='' x-init='new flatpickr($root, @json($options));'
    >

    <x-invalid-feedback :name="$attributes->get('name')" />
    <x-help-text :text="$helpText" />
</div>

@push('css')
    @once
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @endonce

    @once
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @endonce
@endpush