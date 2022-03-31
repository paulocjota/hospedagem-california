@props([
    'value',
    'size' => 8,
    'space',
])

@php
    if(!empty($value)){
        $size = 8;
        $value = dec_to_brl($value);
        $mask = '000.000.000.000,00';
        $mask = mb_substr($mask, - $size);
        $space = mb_substr($mask, 0, mb_strlen($mask) - mb_strlen($value));
    }
@endphp
<span>{!! $space !!}</span>{{ $value }}