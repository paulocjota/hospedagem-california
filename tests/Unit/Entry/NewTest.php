<?php

namespace Tests\Unit\Entry;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Room;
use App\Models\Entry;
// use PHPUnit\Framework\TestCase;

class NewTest extends TestCase
{
    private function createEntry($entryTime = '2022-03-08 08:00:00')
    {
        $room = Room::create([
            'number' => 101,
            'price' => 20,
            'price_per_additional_hour' => 15,
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
    public function entry_8_00_00_now_10_11_00_expects_0_additional_hours()
    {
        Carbon::setTestNow('2022-03-18 10:11:00');
        $entry = $this->createEntry('2022-03-18 08:00:00');

        $this->assertEquals(0, $entry->additional_hours);
    }

    /** @test */
    public function entry_8_00_00_now_10_11_01_expects_1_additional_hours()
    {
        Carbon::setTestNow('2022-03-18 10:11:01');
        $entry = $this->createEntry('2022-03-18 08:00:00');

        $this->assertEquals(1, $entry->additional_hours);
    }


    /** @test */
    public function entry_8_00_00_now_11_00_00_expects_2_additional_hours()
    {
        Carbon::setTestNow('2022-03-18 11:00:00');
        $entry = $this->createEntry('2022-03-18 08:00:00');

        $this->assertEquals(2, $entry->additional_hours);
    }

    /** @test */
    public function entry_8_00_00_now_12_00_00_expects_3_additional_hours()
    {
        Carbon::setTestNow('2022-03-18 12:00:00');
        $entry = $this->createEntry('2022-03-18 08:00:00');

        $this->assertEquals(3, $entry->additional_hours);
    }
}
