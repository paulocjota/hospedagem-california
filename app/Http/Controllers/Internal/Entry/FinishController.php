<?php

namespace App\Http\Controllers\Internal\Entry;

use App\Http\Controllers\Controller;
use App\Models\Entry;
use Illuminate\Http\Request;

class FinishController extends Controller
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

        try {
            $entry->finish();
            return response()->json([
                'message' => 'Entrada finalizada com sucesso',
                'success' => true,
            ]);
        } catch (\Exception $e) {
            $message = 'Falha ao finalizar entrada';

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
