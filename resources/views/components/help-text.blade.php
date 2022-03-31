@props([
    'text' => null,
])

@if(isset($text))
    <small class="form-text text-muted">{{ $text }}</small>
@endif