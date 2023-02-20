<?php

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
        ->group(function () {
            /**
             * Route for business owner
             */
            Route::middleware([
                sprintf('role:%s', Role::RESELLER_OWNER),
            ])->group(base_path('routes/roles/business_owner.php'));

            /**
             * Route for business admin
             */
            Route::middleware([
                sprintf('role:%s', Role::RESELLER_ADMIN),
            ])->group(base_path('routes/roles/business_admin.php'));

            /**
             * Route for business technician
             */
            Route::middleware([
                sprintf('role:%s', Role::RESELLER_TECHNICIAN),
            ])->group(base_path('routes/roles/business_technician.php'));
        });

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
