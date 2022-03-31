<?php

namespace App\Models;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'price', 'quantity', 'monitor_quantity', 'quantity_low', 'photo'
    ];

    public function deletePreviousImage()
    {
        if (
            $this->getOriginal('photo') &&
            File::isFile(Storage::disk('products')->path($this->getOriginal('photo'))) &&
            Storage::disk('products')->exists($this->getOriginal('photo'))
        ) {
            Storage::disk('products')->delete($this->getOriginal('photo'));
        }
    }

    public function deleteCurrentImage()
    {
        if (
            $this->photo &&
            File::isFile(Storage::disk('products')->path($this->photo)) &&
            Storage::disk('products')->exists($this->photo)
        ) {
            Storage::disk('products')->delete($this->photo);
        }
    }

    public function removeFromStock($quantity)
    {
        $this->quantity -= $quantity;
        $this->save();
    }

    public function addToStock($quantity)
    {
        $this->quantity += $quantity;
        $this->save();
    }

    public function isLowStock(): bool
    {
        return $this->quantity < $this->quantity_low ? true : false;
    }

    /**
     * Scope a query to only low stock products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLowStock($query)
    {
        return $query->where('monitor_quantity', 1)
            ->whereRaw('quantity <= quantity_low');
    }
}
