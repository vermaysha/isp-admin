<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\PasswordController;
use App\Http\Controllers\Admin\RegisterController;
use App\Http\Controllers\Admin\ResellerController;
use Illuminate\Support\Facades\Route;

/**
 * Business Menu
 */
Route::name('resellerMenu.')
->prefix('reseller')
->group(function () {
    Route::get('/', [ResellerController::class, 'index'])->name('index');
    Route::get('/{id}', [ResellerController::class, 'detail'])->name('detail')->whereNumber('id');
    Route::get('/create', [ResellerController::class, 'create'])->name('create');
    Route::post('/create', [ResellerController::class, 'store'])->name('store');
});

/**
 * Client menu
 */
Route::name('clientMenu.')
    ->prefix('client')
    ->group(function () {
        Route::get('/', [ClientController::class, 'index'])->name('index');
        Route::get('/{id}', [ClientController::class, 'detail'])->name('detail')->whereNumber('id');
    });

/**
 * User menu
 */
Route::name('userMenu.')
    ->prefix('user')
    ->group(function () {
        Route::get('/{id}', [UserController::class, 'detail'])->name('detail')->whereNumber('id');
    });

/**
 * Admin menu
 */
Route::name('adminMenu.')
    ->prefix('admin')
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/{id?}', [AdminController::class, 'detail'])->name('detail')->whereNumber('id');
        Route::get('/create', [AdminController::class, 'create'])->name('create');
        Route::post('/store', [AdminController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [AdminController::class, 'update'])->name('update')->whereNumber('id');
    });

/**
 * Register menu
 */
Route::name('registerMenu.')
    ->prefix('register')
    ->group(function () {
        Route::get('/', [RegisterController::class, 'index'])->name('index');
        Route::get('/review', [RegisterController::class, 'review'])->name('review');
        Route::get('/register', [RegisterController::class, 'register'])->name('register');
    });

/**
 * Reset Password menu
 */
Route::name('passwordMenu.')
->prefix('password')
->group(function () {
    Route::get('/', [PasswordController::class, 'index'])->name('index');
});
