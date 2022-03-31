<style>
    .even td {
        background-color:#EEEEEE;
    },
    td span {
        color: #FFFFFF;
    },
    .even td span {
        color: #EEEEEE;
    }
</style>

<img src="logo.png" style="border-radius: 80px 40px 80px 40px" />

<h1 style="font-family: 'Courier New', Courier, monospace">Lista de preços</h1>

<table width="100%" style="font-family: 'Courier New', Courier, monospace">
    <thead>
        <th>Nome</th>
        <th>Preço</th>
    </thead>
    <tbody>
        @foreach ($products as $product)
        @if($loop->index % 2 === 0)
            <tr class="even">
        @else
            <tr>
            @endif
                <td>{{ $product->name }}</td>
                <td style="text-align: right">
                    R$ <x-dec-to-brl-with-spaces :value="$product->price" />
                </td>
            </tr>
        @endforeach
    </tbody>
</table>