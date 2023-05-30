<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\api\CartController;
use App\Http\Controllers\api\LoginController;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/category', [CategoryController::class, 'index']);
Route::get('/category/{slug}', [CategoryController::class, 'show']);
Route::get('/categoryHome', [CategoryController::class, 'categoryHome']);

Route::get('/food', [FoodController::class, 'index']);
Route::get('/food/{slug}', [FoodController::class, 'show']);

Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth:api');
Route::post('/profile', [ProfileController::class, 'update'])->middleware('auth:api');
Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->middleware('auth:api');

Route::get('/transaction', [TransactionController::class, 'index'])->middleware('auth:api');
Route::post('/transaction', [TransactionController::class, 'store'])->middleware('auth:api');
Route::post('/transaction/notification', [TransactionController::class, 'notificationHandler']);

Route::get('/cart', [CartController::class, 'index'])->middleware('auth:api');
Route::post('/cart', [CartController::class, 'store'])->middleware('auth:api');
Route::put('/cart/{id}', [CartController::class, 'update'])->middleware('auth:api');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->middleware('auth:api');
Route::delete('/cart', [CartController::class, 'destroyAll'])->middleware('auth:api');
