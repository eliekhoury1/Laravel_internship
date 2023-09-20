<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;



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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::middleware(['auth:sanctum', 'super-admin'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'App\Http\Controllers\AuthController@login');
Route::post('/logout', 'App\Http\Controllers\AuthController@logout')->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function () {
    Route::resource('users', UserController::class);
});

//Route::apiResource('categories', 'CategoryController');

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('categories', CategoryController::class);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::resource('products', ProductController::class);
});