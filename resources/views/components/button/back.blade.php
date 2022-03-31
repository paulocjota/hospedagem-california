@props([
    'text' => 'Voltar',
])

<a {{ $attributes->merge([
    'class' => 'btn btn-light',
    'role' => 'button',
]) }}>{{ $text }}</a>