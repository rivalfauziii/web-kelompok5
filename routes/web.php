<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BranchController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    return redirect('/dashboard');

});

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');

});

/*
|--------------------------------------------------------------------------
| OWNER ONLY
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:owner'
])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | USERS
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'users',
        UserController::class
    );

    /*
    |--------------------------------------------------------------------------
    | BRANCHES
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'branches',
        BranchController::class
    );

});

/*
|--------------------------------------------------------------------------
| OWNER + MANAGER
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:owner,manager'
])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PRODUCTS
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'products',
        ProductController::class
    );

});

/*
|--------------------------------------------------------------------------
| OWNER + MANAGER + WAREHOUSE
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:owner,manager,warehouse'
])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | STOCKS
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'stocks',
        StockController::class
    )->only([
        'index',
        'create',
        'store'
    ]);

});

/*
|--------------------------------------------------------------------------
| OWNER + CASHIER
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| OWNER + CASHIER
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:owner,cashier'
])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | CASHIER
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/cashier',
        [CashierController::class, 'index']
    )->name('cashier.index');

    // INI CHECKOUT
    Route::post(
        '/cashier/checkout',
        [CashierController::class, 'checkout']
    )->name('cashier.checkout');

    /*
    |--------------------------------------------------------------------------
    | TRANSACTIONS
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/transactions',
        [CashierController::class, 'history']
    )->name('transactions.history');

    Route::get(
        '/transactions/{id}',
        [CashierController::class, 'show']
    )->name('transactions.show');

});

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');

});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';