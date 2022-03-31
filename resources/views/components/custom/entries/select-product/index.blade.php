@props([
    'label' => null,
    'helpText' => null,
    'value' => null,
    'entryId',
])

<div class="form-row">
    <div class="form-group col-md-2">
        <x-label text="Qtd." for="quantity-input" />
        <input id="quantity-input" type="number" class="form-control" step="1" min="1" max="99" value="1">
    </div>

    <div class="form-group col-md-8">
        <x-label :text="$label" :for="$attributes->get('id')" />
        <select
            {{ $attributes->merge([
                'class' => 'form-control' . ($errors->has(bracket_to_dot($attributes->get('name'))) ? ' is-invalid' : ''),
                'style' => 'width: 100%'
            ]) }}
        >
        </select>
        <x-invalid-feedback :name="$attributes->get('name')" />
        <x-help-text :text="$helpText" />
    </div>

    <div class="form-group col-md-2">
        <x-label text="​" class="d-none d-md-block" />
        <button title="Adicionar" class="btn btn-primary btn-block" id="add-product">
            <i class="fas fa-solid fa-plus"></i>
        </button>
    </div>
</div>

<input type="hidden" id="product-id-input">

@push('css')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        var select = $('[name="{{ $attributes->get('name') }}"]');

        select.select2({
            minimumInputLength: 2,
            language: {
                searching: function() {
                    return 'Pesquisando...';
                },
                inputTooShort: function() {
                    return 'Por favor, adicione mais texto...';
                },
                noResults: function() {
                    return 'Nenhum resultado encontrado';
                }
            },
            ajax: {
                delay: 500,
                url: @json(route('system.internal.get-products')),
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: data.map(function(element){
                            return {
                                id: element.id,
                                text: element.name + ' - R$ ' + number_format(element.price, '2', ',', '.')
                            }
                        })
                    };
                }
            }
        });

        $('[name="{{ $attributes->get('name') }}"]').on('select2:select', function(event){
            $('#product-id-input').val(event.params.data.id);
        });

        let addProduct = document.getElementById('add-product');

        addProduct.addEventListener('click', function(event){
            let productIdInput = document.getElementById('product-id-input');
            let quantityInput = document.getElementById('quantity-input');
            let quantity = quantityInput.value;
            let productId = productIdInput.value;

            event.preventDefault();

            if(!quantity || !productId){
                return;
            }

            const data = {
                detail: {
                    entryId: @json($entryId),
                    productId: productId,
                    quantity: quantity
                }
            };

            const e = new CustomEvent('add-product', data);
            window.dispatchEvent(e);

            // select.val(null).trigger('change');
            // productIdInput.value = '';
            // quantityInput.value = '';

        }, false);
    });

    function number_format (number, decimals, dec_point, thousands_sep) {
        var n = number, prec = decimals;

        var toFixedFix = function (n,prec) {
            var k = Math.pow(10,prec);
            return (Math.round(n*k)/k).toString();
        };

        n = !isFinite(+n) ? 0 : +n;
        prec = !isFinite(+prec) ? 0 : Math.abs(prec);
        var sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep;
        var dec = (typeof dec_point === 'undefined') ? '.' : dec_point;

        var s = (prec > 0) ? toFixedFix(n, prec) : toFixedFix(Math.round(n), prec);
        // Fix for Internet Explorer parseFloat(0.55).toFixed(0) = 0;

        var abs = toFixedFix(Math.abs(n), prec);
        var _, i;

        if (abs >= 1000) {
            _ = abs.split(/\D/);
            i = _[0].length % 3 || 3;

            _[0] = s.slice(0,i + (n < 0)) +
                _[0].slice(i).replace(/(\d{3})/g, sep+'$1');
            s = _.join(dec);
        } else {
            s = s.replace('.', dec);
        }

        var decPos = s.indexOf(dec);
        if (prec >= 1 && decPos !== -1 && (s.length-decPos-1) < prec) {
            s += new Array(prec-(s.length-decPos-1)).join(0)+'0';
        }
        else if (prec >= 1 && decPos === -1) {
            s += dec+new Array(prec).join(0)+'0';
        }
        return s;
    }
</script>
@endpush