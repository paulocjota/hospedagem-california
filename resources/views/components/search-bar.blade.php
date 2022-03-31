@props([
    'action'
])

<div class="form-group">
    <form action="{{ $action }}" method="GET">
        <input name="q" type="text" class="form-control" placeholder="Pesquisar..." value="{{ request()->q }}">
    </form>
</div>