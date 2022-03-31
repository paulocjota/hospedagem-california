@props([
    'size' => 'md',
    'header' => null,
])

@php
    switch ($size){
        case 'xs':
            $class = 'col-md-4';
            break;
        case 'sm':
            $class = 'col-md-6';
            break;
        case 'md':
            $class = 'col-md-8';
            break;
        case 'lg':
            $class = 'col-md-10';
        case 'xl':
            $class = 'col-md-12';
    }
@endphp

<div class="container">
    <div class="row justify-content-center">
        <div class="{{ $class }}">
            <div class="card">
                @if($header)
                    <div class="card-header">{{ $header }}</div>
                @endif

                <div class="card-body">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>