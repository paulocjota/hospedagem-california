<?php

namespace App\Listeners;

use App\Events\OrderRowDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddProductQuantityToStock
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
     * @param  \App\Events\OrderRowDeleted  $event
     * @return void
     */
    public function handle(OrderRowDeleted $event)
    {
        $orderRow = $event->orderRow;
        $product = $orderRow->product;
        $product->addToStock($orderRow->quantity);
    }
}
