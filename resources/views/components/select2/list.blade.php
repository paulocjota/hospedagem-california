@props([
    'dotName' => bracket_to_dot($attributes->get('name')),
    'label' => null,
    'helpText' => null,
    'value' => null,
])
<x-label :text="$label" :for="$attributes->get('id')" />
<div class="input-group mb-4">
    <input id="amount" type="number" class="form-control" step="1" min="1" max="99" value="1">
    <select
        {{ $attributes->merge([
            'class' => 'form-control' . ($errors->has($dotName) ? ' is-invalid' : ''),
        ]) }}
    >
    </select>
    <div class="input-group-append">
        <button class="btn btn-primary" id="add-product">
            <i class="fas fa-solid fa-plus"></i>
        </button>
    </div>
    <input type="text" id="last-selected-product">
    <x-invalid-feedback :name="$attributes->get('name')" />
    <x-help-text :text="$helpText" />
</div>

@section('js')
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
            $('#last-selected-product').val(event.params.data.id);
        });

        let addProduct = document.getElementById('add-product');
        addProduct.addEventListener('click', function(event){
            event.preventDefault();
            let lastSelectedProduct = $('#last-selected-product');
            let amount = $('#amount');

            console.log(lastSelectedProduct.val());
            console.log(amount.val());

            select.val(null).trigger('change');
            lastSelectedProduct.val('');
            amount.val('');


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
@endsection