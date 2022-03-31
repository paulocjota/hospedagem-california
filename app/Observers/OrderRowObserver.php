<?php

namespace App\Observers;

use App\Events\OrderRowCreated;
use App\Events\OrderRowDeleted;
use App\Models\OrderRow;

class OrderRowObserver
{
    public function creating(OrderRow $orderRow)
    {
        $orderRow->setPrice($orderRow);
    }

    /**
     * Handle the OrderRow "created" event.
     *
     * @param  \App\Models\OrderRow  $orderRow
     * @return void
     */
    public function created(OrderRow $orderRow)
    {
        OrderRowCreated::dispatch($orderRow);
    }

    /**
     * Handle the OrderRow "updated" event.
     *
     * @param  \App\Models\OrderRow  $orderRow
     * @return void
     */
    public function updated(OrderRow $orderRow)
    {
        //
    }

    /**
     * Handle the OrderRow "deleted" event.
     *
     * @param  \App\Models\OrderRow  $orderRow
     * @return void
     */
    public function deleted(OrderRow $orderRow)
    {
        OrderRowDeleted::dispatch($orderRow);
    }

    /**
     * Handle the OrderRow "restored" event.
     *
     * @param  \App\Models\OrderRow  $orderRow
     * @return void
     */
    public function restored(OrderRow $orderRow)
    {
        //
    }

    /**
     * Handle the OrderRow "force deleted" event.
     *
     * @param  \App\Models\OrderRow  $orderRow
     * @return void
     */
    public function forceDeleted(OrderRow $orderRow)
    {
        //
    }
}
