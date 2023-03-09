<?php

use App\Http\Controllers\Client\BillController;
use App\Http\Controllers\Client\InvoiceController;
use App\Http\Controllers\Client\PaymentController;
use App\Http\Controllers\ProfileController as ControllersProfileController;
use Illuminate\Support\Facades\Route;

/**
 * Business Menu
 */
Route::name('invoiceMenu.')
    ->prefix('invoice')
    ->group(function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('index');
    });

/**
 * Client menu
 */
Route::name('billMenu.')
    ->prefix('bill')
    ->group(function () {
        Route::get('/', [BillController::class, 'index'])->name('index');
        Route::get('/outstanding', [BillController::class, 'outstanding'])->name('outstanding');
        Route::get('/history', [BillController::class, 'history'])->name('history');
        Route::get('/{id?}', [BillController::class, 'detail'])->name('detail')->whereNumber('id');
        Route::post('/pay/{id}', [BillController::class, 'pay'])->name('pay')->whereNumber('id');
        Route::get('/invoice/{id}', [BillController::class, 'invoice'])->name('invoice')->whereNumber('id');
    });

/**
 * User menu
 */
Route::name('paymentMenu.')
    ->prefix('payment')
    ->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('index');
    });

/**
 * Admin menu
 */
Route::name('profileMenu.')
    ->prefix('profile')
    ->group(function () {
        Route::get('/', [ControllersProfileController::class, 'client'])->name('client');
    });
