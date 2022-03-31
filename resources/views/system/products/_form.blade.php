<form action="{{ $url }}" method="post" enctype="multipart/form-data">
    @csrf

    @if($product->id !== null)
        @method('PUT')

        @if($product->photo)
            <x-label text="Foto antiga" />
            <img src="{{ route('file-server.product', $product->photo) }}"
                style="width: 100px; height: 100px; display: block; object-fit: contain" class="mb-2"
            >
        @endif
    @endif

    <x-input.file name="photo" id="product_photo" />
    <x-input label="Nome" name="name" id="product_name" :value="$product->name" />
    <x-input.money.brl label="Preço" name="price" id="product_price" :value="$product->price" />
    <x-input label="Quantidade" name="quantity" id="product_quantity" type="number" :value="$product->quantity" min="-9999" step="1" />
    <x-custom.products.quantity-low
        checkboxName="monitor_quantity"
        :checkboxValue="$product->monitor_quantity"
        inputName="quantity_low"
        :inputValue="$product->quantity_low"
    />

        <x-action-bar>
            <x-slot:right>
                <x-button.submit class="mr-2" />
                <x-button.back :href="route('system.products.index')" />
            </x-slot:right>
        </x-action-bar>
</form>