<?php

namespace App\Listeners;

use App\Events\EntryFinished;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ReleaseRoom
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
     * @param  \App\Events\EntryFinished  $event
     * @return void
     */
    public function handle(EntryFinished $event)
    {
        $entry = $event->entry;
        $room = $entry->room;
        $room->release();
    }
}
