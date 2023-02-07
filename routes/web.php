<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ResellerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\BillController as ClientBillController;
use App\Http\Controllers\Client\InvoiceController;
use App\Http\Controllers\Client\PaymentController;
use App\Http\Controllers\Client\ProfileController as ClientProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Reseller\BandwidthController;
use App\Http\Controllers\Reseller\BillController;
use App\Http\Controllers\Reseller\ClientController as ResellerClientController;
use App\Http\Controllers\Reseller\EmployeeController;
use App\Http\Controllers\Reseller\HistoryController;
use App\Http\Controllers\Reseller\ProfileController as ResellerProfileController;
use App\Http\Controllers\Reseller\TransactionController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth',
])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
});

Route::middleware([
    'auth',
    'role:Admin',
])->name('admin.')->group(function () {
    Route::get('/admin/reseller', [ResellerController::class, 'index'])->name('reseller');
    Route::get('/admin/reseller/{id}', [ResellerController::class, 'detail'])->name('reseller.detail')->whereNumber('id');
    Route::get('/admin/reseller/create', [ResellerController::class, 'create'])->name('reseller.create');
    Route::post('/admin/reseller/create', [ResellerController::class, 'store']);

    Route::get('/admin/client', [ClientController::class, 'index'])->name('client');

    Route::get('/admin/user/{id}', [UserController::class, 'detail'])->name('user')->whereNumber('id');
});

Route::middleware([
    'auth',
    'role:Reseller_Owner',
])->name('reseller_owner.')->group(function () {
    Route::get('/reseller/client', [ResellerClientController::class, 'index'])->name('client');

    Route::get('/reseller/bandwidth', [BandwidthController::class, 'index'])->name('bandwidth');
    Route::get('/reseller/bandwidth/{id}', [BandwidthController::class, 'detail'])->name('bandwidth.detail')->whereNumber('id');
    Route::get('/reseller/bandwidth/create', [BandwidthController::class, 'create'])->name('bandwidth.create');
    Route::post('/reseller/bandwidth/create', [BandwidthController::class, 'store'])->name('bandwidth.store');

    Route::get('/reseller/bill', [BillController::class, 'index'])->name('bill');
    Route::get('/reseller/history', [HistoryController::class, 'index'])->name('history');
    Route::get('/reseller/employee', [EmployeeController::class, 'index'])->name('employee');
    Route::get('/reseller/profile', [ResellerProfileController::class, 'index'])->name('profile');

    Route::get('/reseller/transactions', [TransactionController::class, 'index'])->name('transaction');
    Route::get('/reseller/transaction/{id}', [TransactionController::class, 'show'])->name('transaction.detail')->whereNumber('id');
});

Route::middleware([
    'auth',
    'role:Reseller_Admin',
])->name('reseller_admin.')->group(function () {
    Route::get('/adminreseller/client', [ResellerClientController::class, 'index'])->name('client');
    Route::get('/adminreseller/bandwidth', [BandwidthController::class, 'index'])->name('bandwidth');
    Route::get('/adminreseller/bill', [BillController::class, 'index'])->name('bill');
    Route::get('/adminreseller/history', [HistoryController::class, 'index'])->name('history');
    Route::get('/adminreseller/transactions', [TransactionController::class, 'index'])->name('transaction');
    Route::get('/adminreseller/transaction/{id}', [TransactionController::class, 'show'])->name('transaction.detail')->whereNumber('id');
});

Route::middleware([
    'auth',
    'role:Reseller_Teknisi',
])->name('reseller_teknisi.')->group(function () {
    Route::get('/teknisireseller/client', [ResellerClientController::class, 'index'])->name('client');
});

Route::middleware([
    'auth',
    'role:Client',
])->name('client.')->group(function () {
    Route::get('/client/bill', [ClientBillController::class, 'index'])->name('bill');
    Route::get('/client/profile', [ClientProfileController::class, 'index'])->name('profile');
    Route::get('/client/payment', [PaymentController::class, 'index'])->name('payment');
    Route::get('/client/invoice', [InvoiceController::class, 'index'])->name('invoice');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
