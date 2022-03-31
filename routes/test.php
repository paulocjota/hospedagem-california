<?php

if (config('app.debug')) {
    Route::group([
        'as' => 'test.',
        'prefix' => 'test',
    ], function () {

        Route::get('time-view', [App\Http\Controllers\TestController::class, 'timeView'])->name('timeview');
        Route::get('time-test', [App\Http\Controllers\TestController::class, 'timeTest'])->name('timetest');
    });
}
