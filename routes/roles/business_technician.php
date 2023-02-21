<?php

use App\Http\Controllers\Reseller\ClientController;
use App\Http\Controllers\Reseller\PlanController;

Route::prefix('client')->name('clientMenu.')->group(function () {
    Route::get('/', [ClientController::class, 'index'])->name('index');
    Route::get('/{id?}', [ClientController::class, 'detail'])->name('detail')->whereNumber('id');
    Route::get('/create', [ClientController::class, 'create'])->name('create');
    Route::post('/create', [ClientController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [ClientController::class, 'edit'])->name('edit')->whereNumber('id');
    Route::post('/edit/{id}', [ClientController::class, 'update'])->name('update')->whereNumber('id');
});

Route::prefix('plan')->name('planMenu.')->group(function () {
    Route::get('/', [PlanController::class, 'index'])->name('index');
    Route::get('/{id?}', [PlanController::class, 'detail'])->name('detail')->whereNumber('id');
    Route::get('/create', [PlanController::class, 'create'])->name('create');
    Route::post('/create', [PlanController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [PlanController::class, 'edit'])->name('edit')->whereNumber('id');
    Route::post('/edit/{id}', [PlanController::class, 'update'])->name('update')->whereNumber('id');
    Route::get('/delete/{id}', [PlanController::class, 'delete'])->name('delete')->whereNumber('id');
});
