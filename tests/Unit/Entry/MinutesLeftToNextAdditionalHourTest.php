<?php

namespace Tests\Unit\Entry;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Entry;
use Tests\TestCase;
// use PHPUnit\Framework\TestCase;

class MinutesLeftToNextAdditionalHour extends TestCase
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
    public function many_hours_later_and_5_min_should_return_55()
    {
        $entry = $this->createEntry('2022-03-08 08:00:00');
        Carbon::setTestNow('2022-03-08 17:05:00');
        $this->assertEquals(55, $entry->minutes_left_to_next_additional_hour);
    }

    /** @test */
    public function after_two_2h_1m_should_return_10()
    {
        $entry = $this->createEntry('2022-03-08 08:00:00');
        Carbon::setTestNow('2022-03-08 10:01:00');
        $this->assertEquals(10, $entry->minutes_left_to_next_additional_hour);
    }
}
