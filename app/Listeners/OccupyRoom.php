<?php

namespace App\Listeners;

use App\Events\EntryCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OccupyRoom
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\EntryCreated  $event
     * @return void
     */
    public function handle(EntryCreated $event)
    {
        $entry = $event->entry;
        $room = $entry->room;
        $room->occupy();
    }
}
