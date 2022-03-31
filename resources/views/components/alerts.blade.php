@props([
    'class' => null,
    'message' => null,
])

@php
if( Session::get('success') ){
    $class = 'success';
    $message = Session::get($class);
}elseif( Session::get('warning') ){
    $class = 'warning';
    $message = Session::get($class);
}elseif( Session::get('danger') ){
    $class = 'danger';
    $message = Session::get($class);
}elseif( Session::get('error') ){
    $class = 'danger';
    $message = Session::get('error');
}
@endphp

@if($class)
    <div class="alert alert-{{ $class }}" role="alert">
        {{ $message }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif