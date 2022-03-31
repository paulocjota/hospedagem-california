<?php

namespace App\Http\Controllers\Internal\Entry;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetProductsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $this->authorize('view-any products', Product::class);

        return Product::where('name', 'like', '%' . $request->q . '%')
            ->orderBy('name', 'ASC')
            ->get();
    }
}
