<?php

namespace Tests\Unit\Entry;

use App\Models\Room;
use App\Models\Entry;
use Tests\TestCase;
// use PHPUnit\Framework\TestCase;

class RoomOccupationTest extends TestCase
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
    public function when_entry_created_associated_room_should_be_occupied()
    {
        $entry = $this->createEntry();
        $this->assertEquals(true, $entry->room->isOccupied());
    }

    /** @test */
    public function when_entry_finished_associated_room_should_be_released()
    {
        $entry = $this->createEntry();
        $entry->finish();
        $this->assertEquals(false, $entry->room->isOccupied());
    }
}
