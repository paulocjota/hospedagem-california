<?php

namespace App\Http\Controllers\System\Product;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class Printer extends Controller
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
        $products = Product::all();
        $pdf = Pdf::loadView('system.products.print-price-list', ['products' => $products]);
        return $pdf->stream('Lista de preços motel.pdf');
    }
}
