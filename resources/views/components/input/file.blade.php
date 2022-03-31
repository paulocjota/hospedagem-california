@props([
    'dotName' => bracket_to_dot($attributes->get('name')),
    'label' => 'Nenhum arquivo selecionado',
    'helpText' => null,
    'value' => null,
])

<x-label text="Foto a ser enviada" />
<div class="custom-file mb-2">
    <input type="file" accept="image/png, image/jpg, image/jpeg"

        {{ $attributes->merge([
            'class' => 'custom-file-input' . ($errors->has($dotName) ? ' is-invalid' : ''),
        ]) }}
    >
    <x-label class="custom-file-label" :text="$label" :for="$attributes->get('id')" data-browse="Selecionar" />
    <x-invalid-feedback :name="$attributes->get('name')" />
    <x-help-text :text="$helpText" />
</div>

@push('js')
<script>
    $('#' + @json($attributes->get('id'))).on('change',function(){
        var fileName = $(this).val();
        $(this).next('.custom-file-label').html(fileName);
    })
</script>
@endpush