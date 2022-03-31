<?php

namespace App\Http\Controllers\Internal\Entry;

use App\Http\Controllers\Controller;
use App\Models\OrderRow;
use Illuminate\Http\Request;

class DestroyOrderRowController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, OrderRow $orderRow)
    {
        $this->authorize('edit entries', Entry::class);

        try {
            $orderRow->delete();
            return response()->json([
                'message' => 'Linha de ordem excluída com sucesso',
                'success' => true,
            ]);
        } catch (\Exception $e) {
            $message = 'Falha ao excluir linha de ordem';

            if (config('app.debug')) {
                $message = $e->getMessage();
            }

            return response()->json([
                'message' => $message,
                'success' => false,
            ]);
        }
    }
}
