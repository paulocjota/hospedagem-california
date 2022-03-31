<?php

namespace App\Http\Controllers\System\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductIncrementQuantityRequest;

class IncrementQuantity extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('increment-quantity products', Product::class);
        $products = Product::orderBy('name', 'ASC')->get();
        // $products = $products->paginate();

        return view('system.products.increment-quantity')->with([
            'products' => $products,
        ]);
    }

    public function update(ProductIncrementQuantityRequest $request)
    {
        $this->authorize('increment-quantity products', Product::class);
        $data = $request->validated();

        try {
            $ids = [];
            foreach ($data['products'] as $requestProduct) {
                if (!empty($requestProduct['quantity'])) {
                    $ids[] = $requestProduct['id'];
                }
            }

            $products = Product::whereIn('id', $ids)->get();

            DB::beginTransaction();
            foreach ($products as $product) {
                foreach ($request->products as $requestProduct) {
                    if ((int) $product->id ===  (int) $requestProduct['id']) {
                        $product->quantity += $requestProduct['quantity'];
                        $product->save();
                    }
                }
            }
            DB::commit();
            return redirect()->route('system.products.increment-quantity.index')
                ->with('success', 'Quantidade em estoque atualizada com sucesso');
        } catch (\Exception $e) {
            DB::rollBack();

            $message = 'Erro ao atualizar quantidade em estoque';

            if (config('app.debug')) {
                $message = $e->getMessage();
            }

            return redirect()->route('system.products.increment-quantity.index')
                ->with('error', $message);
        }
    }
}
