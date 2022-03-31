<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderRow extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id', 'product_id', 'quantity', 'price',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'total',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Obtem o valor total da linha
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function total(): Attribute
    {
        return Attribute::make(
            get: fn () => (float) bcmul($this->price, $this->quantity, 2),
        );
    }

    /**
     * Caso o mesmo produto já tenho sido adicionado a ordem seta o preço do
     * novo produto com o preço do anterior adicionado. Caso contrário seta com
     * o preço atual do produto. Isso evita situações em que uma ordem é aberta,
     * um produto é adicionado a ordem, o valor do produto é alterado, depois o
     * cliente consome esse mesmo produto novamente, então geraria diferença no
     * valor cobrado.
     *
     * @param  \App\Models\OrderRow $orderRow
     * @return void
     */
    public function setPrice(OrderRow $orderRow)
    {
        $orderRows = OrderRow::where('order_id', $orderRow->order_id)->get();
        $prevOrderRow = $orderRows->firstWhere('product_id', $orderRow->product_id);

        if (isset($prevOrderRow->price)) {
            $this->price = $prevOrderRow->price;
        } else {
            $this->price = $orderRow->product->price;
        }
    }
}
