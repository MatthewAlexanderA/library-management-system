<?php

use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\BorrowController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('book', [BookController::class, 'index']);
Route::post('book-store', [BookController::class, 'store']);
Route::post('book-update/{id}', [BookController::class, 'update']);
Route::delete('book-delete/{id}', [BookController::class, 'destroy']);
Route::get('book-show/{id}', [BookController::class, 'showBook']);

Route::get('history', [BorrowController::class, 'allHistory']);
Route::get('get-request', [BorrowController::class, 'index']);
Route::get('get-borrowed', [BorrowController::class, 'return']);
Route::get('get-out-dated', [BorrowController::class, 'outOffDate']);

Route::post('request/{id}', [BorrowController::class, 'request']);
Route::post('verify/{id}', [BorrowController::class, 'verify']);
Route::post('reject/{id}', [BorrowController::class, 'reject']);
Route::post('return/{id}', [BorrowController::class, 'confirmReturn']);
