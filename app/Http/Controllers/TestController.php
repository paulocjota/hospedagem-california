<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Entry;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        $room = Room::create([
            'number' => 102,
            'occupied' => true,
        ]);

        $entry = Entry::create([
            'room_id' => $room->id,
            'license_plate' => 'ABC2222',
            'entry_time' => Carbon::now()->subHours(4)->subMinutes(11),
            'finished' => false,
        ]);

        // dd($entry->remainingTimeArray()['h']);
        dd($entry->additionalHours());
    }

    public function timeView()
    {
        $entryTime = '2022-03-04 08:00:00';
        $expectedExitTime = (new Carbon($entryTime))->addHours(2)->addMinutes(11);
        $expectedExitTimeWhenOvernight = (new Carbon($entryTime))->addHours(12);

        // $interval = Carbon::now()->diffAsCarbonInterval($expectedExitTime, false);
        // $additionalHours = $interval->h;

        // if ($interval->d) {
        //     $additionalHours += $interval->d * 24;
        // }

        // if ($interval->i >= 11) {
        //     $additionalHours += 1;
        // }

        $additionalHours = (new Carbon($expectedExitTime))->diffInHours(Carbon::now(), false);
        $intervalMinutes = (new Carbon($expectedExitTime))->diffInMinutes(Carbon::now(), false);

        if ($intervalMinutes % 60 >= 11) {
            $additionalHours += 1;
        }

        return view('test.time-view')->with([
            'entryTime' => $entryTime,
            'expectedExitTime' => $expectedExitTime,
            'expectedExitTimeWhenOvernight' => $expectedExitTimeWhenOvernight,
            'additionalHours' => $additionalHours,
        ]);
    }

    public function timeTest()
    {
        return view('test.time-test');
    }
}
