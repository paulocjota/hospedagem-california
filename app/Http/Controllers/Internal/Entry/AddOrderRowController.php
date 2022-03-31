<?php

namespace App\Http\Controllers\Internal\Entry;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Entry;
use Illuminate\Support\Facades\DB;

class AddOrderRowController extends Controller
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

        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'min:1', 'max:999'],
        ]);

        try {
            DB::beginTransaction();
            $order = $entry->order()->firstOrCreate();
            $data['order_id'] = $order->id;
            $order->orderRows()->create($data);
            DB::commit();
            return response()->json(['message' => 'Entrada alterada com sucesso!']);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = 'Falha ao editar entrada';

            if (config('app.debug')) {
                $message = $e->getMessage();
            }

            return response()->json(['message' => $message]);
        }
    }
}
