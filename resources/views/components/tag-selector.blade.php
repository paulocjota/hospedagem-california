<div x-data='tagSelector( @json($label), @json($name), @json($route), @json($value) )'>
    <div class="position-relative">
        <div class="form-group">
            <label x-on:click="$refs.search.focus();" x-text="label"></label>
            <input type="text" class="form-control" x-on:input="search($el.value)" x-ref="search" x-on:click.outside="closeList" placeholder="Pesquisar...">
            <div x-bind:class="open ? 'd-block' : 'd-none'" class="d-none">
                <div class="position-absolute mt-2 w-100 bg-white border rounded" x-ref="results" x-bind:class="open ? 'd-block' : 'd-none'" class="d-none">
                    <template x-for="value in filteredData">
                        <div class="m-2 p-2" role="button" x-text="value.name" x-on:mouseover="$el.classList.add('bg-info')" x-on:mouseover.outside="$el.classList.remove('bg-info')"
                            x-on:click="addValue(value.id, value.name)"
                        ></div>
                    </template>
                </div>
            </div>

            <div>
                <template x-for="(item, index) in currentValues">
                    <div :key="item.id" class="bg-info d-inline-flex align-items-center mt-2 mr-1 rounded">
                        <span x-text="item.name" class="ml-2 mr-1 text-truncate"></span>
                        <button type="button" role="button" class="btn btn-info btn-sm d-inline-block align-middle m-0" x-on:click.prevent="remove(item.id)" style="width: 2rem; height: 2rem;">
                            <i class="fas fa-times-circle" style="width: 1.0rem; height: 1.0rem;"></i>
                        </button>
                        <input type="hidden" :name="name + '[' + index + '][' + idKey + ']'" :value="item[idKey]" />
                        <input type="hidden" :name="name + '[' + index + '][' + displayKey + ']'" :value="item[displayKey]" />
                        <input type="hidden" :name="name + '_ids[]'" :value="item[idKey]" />
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

@push('css')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('tagSelector', (label, name, route, old = [], idKey = 'id', displayKey = 'name') => ({
            route: route,
            data: [],
            label: label,
            filteredData: [],
            currentValues: old,
            open: false,
            searchMin: 3,
            name: name,
            idKey: idKey,
            displayKey: displayKey,
            init(){
                this.loadData();
            },
            addValue(id, name){
                let alreadyPresent = this.currentValues.some(function(item){
                    return item.id === id;
                });

                if(alreadyPresent){
                    this.closeList();
                    return;
                }

                this.currentValues.push({
                    id: id,
                    name: name
                });

                this.currentValues.sort(function(a, b) {
                    return a.name.localeCompare(b.name);
                });

                this.closeList();
                this.$refs.search.focus();
            },
            closeList(){
                this.open = false;
                this.$refs.search.value = '';
            },
            search(value){
                if(value.len < this.searchMin){
                    this.open = false;
                    return;
                };
                this.filteredData = this.data.filter(function(item){
                    return item.name.includes(value);
                });

                this.open = true;
            },
            remove(id){
                this.currentValues.forEach(function(item, index){
                    item.id === id ? this.currentValues.splice(index, 1) : '';
                }.bind(this));
                this.$refs.search.focus();
            },
            loadData(){
                let xhr = new XMLHttpRequest();
                xhr.open('GET', this.route, true);
                xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
                xhr.send();

                xhr.addEventListener('readystatechange', function(e) {
                    if( xhr.readyState === 4 && xhr.status === 200){
                        this.data = JSON.parse(xhr.responseText);
                    }
                }.bind(this), false);
            }
        }))
    })
</script>
@endpush