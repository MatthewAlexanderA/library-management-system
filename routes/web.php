<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;

use App\Http\Controllers\DashboardController;

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
Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest');

Route::resource('dashboard', DashboardController::class)->middleware('auth');

Route::resource('book', BookController::class)->middleware('auth');
Route::resource('borrow', BorrowController::class)->middleware('auth');

Route::get('/panel', [LoginController::class, 'index'])->name('panel')->middleware('guest');
Route::post('/panel', [LoginController::class, 'authentication'])->name('authentication');

Route::get('/login', [LoginController::class, 'user'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'auth'])->name('auth');

Route::resource('register', RegistController::class)->middleware('guest');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
