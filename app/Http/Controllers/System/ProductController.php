<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Product::class, 'product');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::orderBy('name', 'ASC');

        $q = trim($request->input('q'));

        if (!empty($q)) {
            $products->where('name', 'like', '%' . $q . '%');
        }

        $products = $products->paginate();

        return view('system.products.index')->with([
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('system.products.create')->with([
            'product' => new Product,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        try {
            $data = $request->validated();
            if ($request->hasFile('photo')) {
                $data['photo'] = $request->file('photo')->store('', 'products');
            }
            Product::create($data);
            return redirect()->route('system.products.index')
                ->with('success', 'Produto adicionado com sucesso');
        } catch (\Exception $e) {
            $message = 'Erro ao adicionar produto';

            if (config('app.debug')) {
                $message = $e->getMessage();
            }

            return redirect()->route('system.products.index')
                ->with('error', $message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('system.products.show', [
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('system.products.edit')->with([
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        try {
            $data = $request->validated();
            if ($request->hasFile('photo')) {
                $data['photo'] = $request->file('photo')->store('', 'products');
            }
            $product->update($data);
            return redirect()->route('system.products.index')
                ->with('success', 'Produto editado com sucesso');
        } catch (\Exception $e) {
            $message = 'Falha ao editar produto';

            if (config('app.debug')) {
                $message = $e->getMessage();
            }

            return redirect()->route('system.products.index')
                ->with('error', $message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return redirect()->route('system.products.index')
                ->with('success', 'Produto excluído com sucesso');
        } catch (\Exception $e) {
            $message = 'Falha ao excluir produto';

            if (config('app.debug')) {
                $message = $e->getMessage();
            }

            return redirect()->route('system.products.index')
                ->with('error', $message);
        }
    }
}
