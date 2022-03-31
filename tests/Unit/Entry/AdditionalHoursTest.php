<?php

namespace Tests\Unit\Entry;

use Carbon\Carbon;
use Tests\TestCase;
// use PHPUnit\Framework\TestCase;
use App\Models\Room;
use App\Models\Entry;

class AdditionalHoursTest extends TestCase
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
    public function entry_08_00_00_actual_10_11_00_should_return_0_additional_hours()
    {
        Carbon::setTestNow('2022-03-08 10:11:00');
        $entry = $this->createEntry();
        $this->assertEquals('2022-03-08 10:00:00', $entry->expected_exit_time);
        $this->assertEquals('2022-03-08 10:11:00', $entry->expected_exit_time_with_addition);
        $this->assertEquals(0, $entry->additional_hours);
        $this->assertEquals(0, $entry->total_additional_hours);
    }

    /** @test */
    public function entry_08_00_00_actual_10_11_01_should_return_1_additional_hours()
    {
        Carbon::setTestNow('2022-03-08 10:11:01');
        $entry = $this->createEntry();
        $this->assertEquals('2022-03-08 10:00:00', $entry->expected_exit_time);
        $this->assertEquals('2022-03-08 10:11:00', $entry->expected_exit_time_with_addition);
        $this->assertEquals(1, $entry->additional_hours);
        $this->assertEquals(15, $entry->total_additional_hours);
    }

    /** @test */
    public function entry_08_00_00_actual_10_59_59_should_return_1_additional_hours()
    {
        Carbon::setTestNow('2022-03-08 10:59:59');
        $entry = $this->createEntry();
        $this->assertEquals('2022-03-08 10:00:00', $entry->expected_exit_time);
        $this->assertEquals('2022-03-08 10:11:00', $entry->expected_exit_time_with_addition);
        $this->assertEquals(1, $entry->additional_hours);
        $this->assertEquals(15, $entry->total_additional_hours);
    }


    /** @test */
    public function entry_08_00_00_actual_11_00_00_should_return_2_additional_hours()
    {
        Carbon::setTestNow('2022-03-08 11:00:00');
        $entry = $this->createEntry();
        $this->assertEquals('2022-03-08 10:00:00', $entry->expected_exit_time);
        $this->assertEquals('2022-03-08 10:11:00', $entry->expected_exit_time_with_addition);
        $this->assertEquals(2, $entry->additional_hours);
        $this->assertEquals(30, $entry->total_additional_hours);
    }

    /** @test */
    public function entry_08_00_00_actual_11_59_59_should_return_2_additional_hours()
    {
        Carbon::setTestNow('2022-03-08 11:59:59');
        $entry = $this->createEntry();
        $this->assertEquals('2022-03-08 10:00:00', $entry->expected_exit_time);
        $this->assertEquals('2022-03-08 10:11:00', $entry->expected_exit_time_with_addition);
        $this->assertEquals(2, $entry->additional_hours);
        $this->assertEquals(30, $entry->total_additional_hours);
    }

    /** @test */
    public function entry_08_00_00_actual_12_00_00_should_return_3_additional_hours()
    {
        Carbon::setTestNow('2022-03-08 12:00:00');
        $entry = $this->createEntry();
        $this->assertEquals('2022-03-08 10:00:00', $entry->expected_exit_time);
        $this->assertEquals('2022-03-08 10:11:00', $entry->expected_exit_time_with_addition);
        $this->assertEquals(3, $entry->additional_hours);
        $this->assertEquals(45, $entry->total_additional_hours);
    }

    /** @test */
    public function additional_hours_should_not_calculate_negative_hours()
    {
        Carbon::setTestNow('2022-03-09 09:45:00');
        $entry = $this->createEntry('2022-03-09 09:35:00');
        $this->assertEquals(0, $entry->additional_hours); // 0 instead of -1
        $this->assertEquals(0, $entry->total_additional_hours); // 0 instead of -15
    }
}
