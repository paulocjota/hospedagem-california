@props([
    'target',
    'title',
    'text',
    'route',
])

<button class="btn btn-danger mr-2" data-toggle="modal" type="button"
    data-target="{{ $target }}"
    data-action="{{ $route }}"
    data-title="{{ $title }}"
    data-text="{{ $text }}"
>
    Finalizar
</button>