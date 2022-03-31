<?php

namespace App\Observers;

use App\Events\EntryCreated;
use Carbon\Carbon;
use App\Models\Entry;

class EntryObserver
{
    public function creating(Entry $entry)
    {
        if (!$entry->entry_time) {
            $entry->entry_time = Carbon::now();
        }

        $entry->setPricesThroughRoom();
    }

    /**
     * Handle the Entry "created" event.
     *
     * @param  \App\Models\Entry  $entry
     * @return void
     */
    public function created(Entry $entry)
    {
        EntryCreated::dispatch($entry);
    }

    /**
     * Handle the Entry "updated" event.
     *
     * @param  \App\Models\Entry  $entry
     * @return void
     */
    public function updated(Entry $entry)
    {
        //
    }

    /**
     * Handle the Entry "deleted" event.
     *
     * @param  \App\Models\Entry  $entry
     * @return void
     */
    public function deleted(Entry $entry)
    {
        //
    }

    /**
     * Handle the Entry "restored" event.
     *
     * @param  \App\Models\Entry  $entry
     * @return void
     */
    public function restored(Entry $entry)
    {
        //
    }

    /**
     * Handle the Entry "force deleted" event.
     *
     * @param  \App\Models\Entry  $entry
     * @return void
     */
    public function forceDeleted(Entry $entry)
    {
        //
    }
}
