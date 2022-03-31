@props([
    'entryId',
])

<x-custom.entries.select-product name="products" label="Produto" id="product-selector" entryId="{{ $entryId }}" />

<div x-data="productTable()" x-bind="listener" class="table-responsive">
    <table class="table table-sm table-borderless table-hover">
        <thead>
            <tr>
                <th scope="col">Qtd.</th>
                <th scope="col">Produto</th>
                <th scope="col">Preço un. R$</th>
                <th scope="col">Total R$</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <template x-for="el in get(data, '0.order.order_rows', [])" :key="el.id">
                <tr>
                    <td x-text="el.quantity"></td>
                    <td x-text="el.product.name"></td>
                    <td x-html="format(el.price)"></td>
                    <td x-html="format(el.total)"></td>
                    <td>
                        <button title="Remover" class="btn btn-danger btn-sm rounded-circle mx-2" data-toggle="modal" type="button"
                            x-bind:data-target="'#modal-delete-product'"
                            x-bind:data-action='@json(route('system.internal.destroy-order-row', ['orderRow' => 'ORDER_ROW_ID'])).replace("ORDER_ROW_ID", el.id)'
                            x-bind:data-title="'Remover produto'"
                            x-bind:data-text="'Deseja realmente excluir o produto ' + el.product.name + '?'"
                        >
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            </template>
            <tr>
                <td>1</td>
                <td>Serviço Quarto</td>
                <td x-html="format( get(data, '0.room_price') )"></td>
                <td x-html="format( get(data, '0.room_price') )"></td>
                <td></td>
            <tr>
            <tr>
                <td x-html="get(data, '0.additional_hours')"></td>
                <td>Horas adicionais</td>
                <td x-html="format( get(data, '0.room_price_per_additional_hour') )"></td>
                <td x-html="format( get(data, '0.total_additional_hours') )"></td>
                <td></td>
            <tr>
            <tr>
                <td colspan="2"></td>
                <th class="text-right">Total</th>
                <td x-html="format( get(data, '0.order.total_with_service') ? get(data, '0.order.total_with_service') : get(data, '0.total') )"></td>
                <td></td>
            <tr>
        </tbody>
    </table>

    <span class="badge mb-5" x-ref="badge"></span>
</div>

@push('css')

<style>
    @keyframes pulse {
        0% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(255, 82, 82, 0.7);
        }

        70% {
            transform: scale(1);
            box-shadow: 0 0 0 10px rgba(255, 82, 82, 0);
        }

        100% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(255, 82, 82, 0);
        }
    }

.pulse{
    animation: pulse 1s linear infinite;
}

</style>

<script>
    function get(target, key, defaultVal = '') {
        let keys = key.split('.'), last = target;

        for (let i = 0; i <= keys.length - 1; i++) {
            if (typeof last[keys[i]] === 'undefined' ||
                last[keys[i]] === null
            ) {
                return defaultVal;
            }

            if (i === keys.length - 1) {
                return last[keys[i]];
            } else {
                last = last[keys[i]];
            }
        }
    }

    document.addEventListener('alpine:init', () => {
        Alpine.data('productTable', () => ({
            entryId: @json($entryId),
            data: [{
                order_rows: [],
            }],
            init(){
                this.loop();
                this.$watch('data[0].minutes_left_to_next_additional_hour', value => this.setBadgeClass(value));
            },
            loop(){
                this.loadProducts(this.entryId);
                setTimeout(this.loop.bind(this), 5000);
            },
            setBadgeClass(value){
                let min = value;
                let leftWord = 'Faltam';
                let minWord = 'minutos';

                if(min !== false){
                    this.$refs.badge.style.display = 'block';
                }else{
                    this.$refs.badge.style.display = 'none';
                }

                if(min <= 1){
                    this.$refs.badge.innerText = 'Faltam apenas alguns segundos para a próxima hora adicional';
                    this.$refs.badge.classList.add('pulse');
                }else{
                    this.$refs.badge.innerText = 'Faltam ' + min + ' ' + minWord + ' para a próxima hora adicional';
                    this.$refs.badge.classList.remove('pulse');
                }

                if(min <= 10){
                    this.$refs.badge.classList.remove('badge-danger', 'badge-warning', 'badge-success');
                    this.$refs.badge.classList.add('badge-danger');
                }else if(min >= 11 && min <= 30){
                    this.$refs.badge.classList.remove('badge-danger', 'badge-warning', 'badge-success');
                    this.$refs.badge.classList.add('badge-warning');
                }else if(min >= 31 && min <= 60){
                    this.$refs.badge.classList.remove('badge-danger', 'badge-warning', 'badge-success');
                    this.$refs.badge.classList.add('badge-success');
                }
            },
            listener: {
                ['x-on:add-product.window'](event) {
                    const { productId, quantity } = event.detail;
                    this.addProduct(productId, quantity);
                },
                ['x-on:reload-products.window'](event){
                    this.loadProducts(this.entryId);
                }
            },
            getSpanValue(value){
                let size = 9;
                let currencyStr = '000.000.000.000,00';
                let targetCurrencyStr = currencyStr.substring( currencyStr.length - size );
                let formatted = this.formatMoney(value);
                return '<span style="opacity: 0">' + formatted.padStart(size, targetCurrencyStr).replace(formatted, '') + '</span>';
            },
            format(value){
                if(!value) return '';
                return this.getSpanValue(value) + this.formatMoney(value);
            },
            formatMoney(value){
                return number_format(value, '2', ',', '.');
            },
            addProduct(productId, quantity){
                let metaCsrf = document.querySelector('meta[name="csrf-token"]');
                let xhr = new XMLHttpRequest();
                let route = @json(route('system.internal.add-order-row', ['entry' => 'ENTRY_ID']));
                route = route.replace('ENTRY_ID', this.entryId);

                xhr.open('POST', route, true);

                xhr.setRequestHeader('X-CSRF-TOKEN', metaCsrf.getAttribute('content'));
                xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
                xhr.send(JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                }));

                xhr.addEventListener('readystatechange', function(e) {
                    if( xhr.readyState === 4 && xhr.status === 200){
                        this.loadProducts(this.entryId);
                    }
                }.bind(this), false);
            },
            loadProducts(entryId){
                let xhr = new XMLHttpRequest();
                xhr.open('GET', @json(route('system.internal.get-order-rows', ['entry' => 'ENTRY_ID'])).replace('ENTRY_ID', entryId), true);
                xhr.send();

                xhr.addEventListener('readystatechange', function(e) {
                    if( xhr.readyState === 4 && xhr.status === 200){
                        this.data = JSON.parse(xhr.responseText);
                        console.log(xhr.responseText);
                    }
                }.bind(this), false);
            },
        }))
    })
</script>
@endpush