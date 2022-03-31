<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/file-server/product/{path}', [App\Http\Controllers\System\FileServerController::class, 'product'])
    ->name('file-server.product')
    ->where('path', '([A-Z|a-z|0-9]*\.(jpg|jpeg|png|bmp))$')
    ->middleware('auth');

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('system.dashboard');
    }
    return redirect()->route('login');
});

Auth::routes(['register' => false]);

Route::group([
    'as' => 'system.',
    'prefix' => 'sistema',
    'middleware' => ['auth'],
], function () {

    Route::group([
        'as' => 'internal.',
        'prefix' => 'internal',
    ], function () {
        Route::get('entries/get-roms', App\Http\Controllers\Internal\Entry\GetRomsController::class)->name('get-roms');
        Route::get('entries/{entry}/get-order-rows', App\Http\Controllers\Internal\Entry\GetOrderRowsController::class)->name('get-order-rows');
        Route::delete('entries/order-row/{orderRow}', App\Http\Controllers\Internal\Entry\DestroyOrderRowController::class)->name('destroy-order-row');
        Route::get('entries/get-products', App\Http\Controllers\Internal\Entry\GetProductsController::class)->name('get-products');
        Route::post('entries/{entry}/add-order-row', App\Http\Controllers\Internal\Entry\AddOrderRowController::class)->name('add-order-row');

        Route::get('roles/get-roles', App\Http\Controllers\Internal\Role\GetRolesController::class)->name('get-roles');
    });

    Route::get('produtos/imprimir-lista-precos', App\Http\Controllers\System\Product\Printer::class)->name('products.print-price-list');

    Route::get('/', [App\Http\Controllers\System\DashboardController::class, 'index'])->name('dashboard');
    Route::get('produtos/incrementar-estoque', [App\Http\Controllers\System\Product\IncrementQuantity::class, 'index'])->name('products.increment-quantity.index');
    Route::post('produtos/incrementar-estoque', [App\Http\Controllers\System\Product\IncrementQuantity::class, 'update'])->name('products.increment-quantity');

    Route::get('entradas/{room}/criar', [App\Http\Controllers\System\EntryController::class, 'create'])->name('entries.create');
    Route::post('entradas/store', [App\Http\Controllers\System\EntryController::class, 'store'])->name('entries.store');
    Route::get('entradas/{entry}/editar', [App\Http\Controllers\System\EntryController::class, 'edit'])->name('entries.edit');
    Route::match(['put', 'patch'], 'entradas/{entry}', [App\Http\Controllers\System\EntryController::class, 'update'])->name('entries.update');
    Route::match(['put', 'patch'], 'entradas/{entry}/finalizar', App\Http\Controllers\Internal\Entry\FinishController::class)->name('entries.finish');

    Route::get('quartos/alterar-preco-hora-adicional', [App\Http\Controllers\System\RoomController::class, 'editPricePerAdditionalHour'])->name('rooms.edit-price-per-additional-hour');
    Route::match(['put', 'patch'], 'quartos/atualizar-preco-hora-adicional', [App\Http\Controllers\System\RoomController::class, 'updatePricePerAdditionalHour'])->name('rooms.update-price-per-additional-hour');

    Route::resource('usuarios', App\Http\Controllers\System\UserController::class)
        ->parameters([
            'usuarios' => 'user'
        ])->names('users');

    Route::resource('produtos', App\Http\Controllers\System\ProductController::class)
        ->parameters([
            'produtos' => 'product'
        ])->names('products');

    Route::resource('quartos', App\Http\Controllers\System\RoomController::class)->parameters([
        'quartos' => 'room'
    ])->names('rooms');
});

include('test.php');
