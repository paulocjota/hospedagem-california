<?php

namespace App\Http\Controllers\Internal\Entry;

use App\Models\Room;
use App\Http\Controllers\Controller;

class GetRomsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     *  @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $this->authorize('view-any entries', Room::class);

        return Room::orderBy('number', 'ASC')
            ->with('latestEntry')->get();
    }
}
