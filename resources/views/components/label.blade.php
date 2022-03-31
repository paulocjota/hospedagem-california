@props([
    'text' => null,
])

@if(isset($text))
    <label {{ $attributes }}>{{ $text }}</label>
@endif