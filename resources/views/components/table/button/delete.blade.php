@props([
    'target',
    'title',
    'text',
    'route',
])

<button title="Excluir" class="btn btn-danger btn-sm rounded-circle mx-2" data-toggle="modal" type="button"
    data-target="{{ $target }}"
    data-action="{{ $route }}"
    data-title="{{ $title }}"
    data-text="{{ $text }}"
>
    <i class="fas fa-trash-alt"></i>
</button>