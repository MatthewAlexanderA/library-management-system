<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;

use App\Http\Controllers\PageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingController;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistController;
use Illuminate\Auth\Events\Logout;

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
Route::get('/', [PageController::class, 'index'])->name('index');
Route::get('show-book/{slug}', [BookController::class, 'showBook'])->name('show-book');

Route::middleware(['auth'])->group(function () {
    
    Route::resource('dashboard', DashboardController::class);
    Route::resource('setting', SettingController::class);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware('checkLevel:staff')->group(function () {
        Route::resource('book', BookController::class);

        Route::get('verify', [BorrowController::class, 'index'])->name('verify');
        Route::get('verify-request/{id}', [BorrowController::class, 'inputDate'])->name('verify-request');
        Route::put('update-request/{id}', [BorrowController::class, 'verify'])->name('update-request');
        Route::put('reject-request/{id}', [BorrowController::class, 'reject'])->name('reject-request');
        Route::get('return-book', [BorrowController::class, 'return'])->name('return-book');
        Route::put('confirm-return/{id}', [BorrowController::class, 'confirmReturn'])->name('confirm-return');
        Route::get('request-history', [BorrowController::class, 'allHistory'])->name('request-history');
        Route::get('out-off-date', [BorrowController::class, 'outOffDate'])->name('out-off-date');
    });

    Route::middleware('checkLevel:member')->group(function () {
        Route::get('book-list', [BorrowController::class, 'list'])->name('book-list');
        Route::get('history', [BorrowController::class, 'history'])->name('history');
        Route::post('borrow-request/{id}', [BorrowController::class, 'request'])->name('borrow-request');
    });

});

Route::middleware(['guest'])->group(function () {
    
    Route::get('/panel', [LoginController::class, 'index'])->name('panel');
    Route::post('/panel', [LoginController::class, 'authentication'])->name('authentication');
    
    Route::get('/login', [LoginController::class, 'user'])->name('login');
    Route::post('/login', [LoginController::class, 'auth'])->name('auth');
    
    Route::resource('register', RegistController::class);

});
