<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entry_id',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    // protected $appends = ['total'];

    public function entry()
    {
        return $this->belongsTo(Entry::class);
    }

    public function orderRows()
    {
        return $this->hasMany(OrderRow::class);
    }

    /**
     * Obtem o valor total da ordem
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function total(): Attribute
    {
        return Attribute::make(
            get: function () {
                $total = 0;
                foreach ($this->orderRows as $orderRow) {
                    $total = bcadd($total, $orderRow->total, 2);
                }
                return $total;
            }
        );
    }

    protected function totalWithService(): Attribute
    {
        return Attribute::make(
            get: function () {
                $total = 0;
                $total = bcadd($this->total, $this->entry->total, 2);
                return $total;
            }
        );
    }
}
