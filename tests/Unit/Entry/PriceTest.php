<?php

namespace Tests\Unit\Entry;

use App\Models\Room;
use App\Models\Entry;
use Tests\TestCase;
// use PHPUnit\Framework\TestCase;

class PriceTest extends TestCase
{
    private function createEntry($entryTime = '2022-03-08 08:00:00')
    {
        $room = Room::create([
            'number' => 101,
            'price' => 55,
            'price_per_additional_hour' => 35,
        ]);

        $entry = Entry::create([
            'room_id' => $room->id,
            'license_plate' => 'ABC1234',
            'entry_time' => $entryTime,
            'overnight' => false,
            'finished' => false,
        ]);

        return $entry;
    }

    /** @test */
    public function entry_should_get_prices_automatically_from_room()
    {
        $entry = $this->createEntry();
        $this->assertEquals(55, $entry->room_price);
        $this->assertEquals(35, $entry->room_price_per_additional_hour);
    }
}
