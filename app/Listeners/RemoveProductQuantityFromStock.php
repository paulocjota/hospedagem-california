<?php

namespace App\Listeners;

use App\Events\OrderRowCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RemoveProductQuantityFromStock
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
     * @param  \App\Events\OrderRowCreated  $event
     * @return void
     */
    public function handle(OrderRowCreated $event)
    {
        $orderRow = $event->orderRow;
        $product = $orderRow->product;
        $product->removeFromStock($orderRow->quantity);
    }
}
