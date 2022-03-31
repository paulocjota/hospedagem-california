<div class="w-100 my-2 d-flex">
    @if(isset($left))
        <div class="d-flex justify-content-start {{ isset($right) ? 'w-50' : 'w-100' }}">
            {{ $left }}
        </div>
    @endif

    @if(isset($right))
        <div class="d-flex justify-content-end {{ isset($left) ? 'w-50' : 'w-100' }}">
            {{ $right }}
        </div>
    @endif
</div>