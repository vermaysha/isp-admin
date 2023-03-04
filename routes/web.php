<?php

use App\Http\Controllers\AddresssController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;
use Spatie\Health\Http\Controllers\HealthCheckResultsController;

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

Route::middleware([
    'auth',
])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    /**
     * Address
     */
    Route::middleware([
        'api',
    ])->prefix('address')->group(function () {
        Route::get('/provinces', [AddresssController::class, 'provinces'])->name('provinces');
        Route::get('/cities/{code}', [AddresssController::class, 'cities'])->name('cities')->whereNumber('code');
        Route::get('/districts/{code}', [AddresssController::class, 'districts'])->name('districts')->whereNumber('code');
        Route::get('/villages/{code}', [AddresssController::class, 'villages'])->name('villages')->whereNumber('code');
    });

    /**
     * Route for admin
     */
    Route::middleware([
        sprintf('role:%s', Role::ADMIN),
    ])
        ->name('admin.')
        ->prefix('admin')
        ->group(base_path('routes/roles/admin.php'));

    Route::name('business.')
        ->prefix('business')
        ->group(base_path('routes/roles/business.php'));

    /**
     * Route for client
     */
    Route::middleware([
        sprintf('role:%s', Role::CLIENT),
    ])
        ->prefix('client')
        ->name('client.')
        ->group(base_path('routes/roles/client.php'));
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/signup', [AuthController::class, 'signup'])->name('signup');

Route::get('/status', HealthCheckResultsController::class)->name('status');
