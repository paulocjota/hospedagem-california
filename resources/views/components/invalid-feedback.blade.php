@props([
    'dotName' => bracket_to_dot($attributes->get('name')),
])

@if($attributes->get('name') !== null && $errors->has($dotName))
    <div class="invalid-feedback">
        {{ $errors->first($dotName) }}
    </div>
@endif