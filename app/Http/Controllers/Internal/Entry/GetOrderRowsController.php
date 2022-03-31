<?php

namespace App\Http\Controllers\Internal\Entry;

use App\Models\Entry;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetOrderRowsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Entry $entry)
    {
        $this->authorize('edit entries', Entry::class);

        $entry = Entry::where('id', $entry->id)->with([
            'room', 'order', 'order.orderRows', 'order.orderRows.product'
        ])->get()->append(['total', 'total_additional_hours', 'additional_hours', 'minutes_left_to_next_additional_hour'])
            ->map(function (Entry $entry) {
                if ($entry->order) {
                    $entry->order->each(function () use ($entry) {
                        $entry->order->append('total');
                        $entry->order->append('total_with_service');
                    });
                }
                return $entry;
            });
        return response()->json($entry);
    }
}
