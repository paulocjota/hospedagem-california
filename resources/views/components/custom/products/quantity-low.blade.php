@props([
    'label' => null,
    'helpText' => null,
    'checkboxValue' => 0,
    'inputValue' => null,
    'checkboxName',
    'inputName',
])

<div x-data='checkboxWithInput'>
    <div class="custom-control custom-checkbox mb-2">
        <input type="checkbox" class="custom-control-input {{ $errors->has('monitor_quantity') ? ' is-invalid' : '' }}" id="monitor_quantity" x-ref="checkbox" value="1" name="monitor_quantity" x-on:click="onClick($el)"
            @if(old('monitor_quantity', $errors->isEmpty() ? $checkboxValue : ''))
                checked="checked"
            @endif
        >
        <label class="custom-control-label" for="monitor_quantity" x-ref="checkboxLabel">Monitorar quantidade baixa</label>
    </div>

    <div x-ref="inputWrapper" style="display: none;" class="form-group">
        <label>Quantidade baixa</label>
        <input type="number" class="form-control {{ $errors->has('quantity_low') ? ' is-invalid' : '' }}" x-ref="input" name="quantity_low" min="1" step="1" value="{{ old('quantity_low', $inputValue) }}">
        <x-invalid-feedback name="quantity_low" />
    </div>

    <input type="hidden" value="0" x-ref="hidden" />
</div>

<x-help-text :text="$helpText" />

@push('css')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('checkboxWithInput', () => ({
            init() {
                if(this.$refs.checkbox.checked){
                    this.$refs.inputWrapper.style.display = 'block';
                    this.$refs.hidden.removeAttribute('name');
                }else{
                    this.$refs.inputWrapper.style.display = 'none';
                    this.$refs.hidden.setAttribute('name', 'monitor_quantity');
                }
            },
            onClick(el){
                if(el.checked){
                    this.$refs.inputWrapper.style.display = 'block';
                    this.$refs.hidden.removeAttribute('name');
                }else{
                    this.$refs.hidden.setAttribute('name', 'monitor_quantity');
                    this.$refs.inputWrapper.style.display = 'none';
                    this.$refs.input.value = '';
                }
            }
        }));
    });
</script>
@endpush