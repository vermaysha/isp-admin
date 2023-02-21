<?php

use App\Http\Controllers\Reseller\BillController;

Route::prefix('bill')->name('billMenu.')->group(function () {
    Route::get('/', [BillController::class, 'index'])->name('index');
    Route::get('/history', [BillController::class, 'index'])->name('history');
    Route::get('/{id?}', [BillController::class, 'show'])->name('detail')->whereNumber('id');
    Route::get('//bills', [BillController::class, 'bills'])->name('bill');

    Route::get('/outstanding', [BillController::class, 'outstanding'])->name('outstanding');
    Route::get('/paid', [BillController::class, 'paid'])->name('paid');
    Route::get('/paid-off', [BillController::class, 'paidOff'])->name('paidOff');

    Route::post('/confirm/{id}', [BillController::class, 'confirm'])->name('confirm')->whereNumber('id');
});
