<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number', 'price', 'price_per_additional_hour'
    ];

    public function isOccupied()
    {
        return $this->occupied;
    }

    public function latestEntry()
    {
        return $this->hasOne(Entry::class)->latestOfMany();
    }

    public function occupy()
    {
        $this->occupied = true;
        $this->save();
    }


    public function release()
    {
        $this->occupied = false;
        $this->save();
    }

    public static function updateAllPricePerAdditionalHour($price_per_additional_hour)
    {
        self::where('id', '>', 0)->update([
            'price_per_additional_hour' => $price_per_additional_hour,
        ]);
    }
}
