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
//Role in middleware
//
Route::group(['middleware' => ['role:super-admin']], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::post('/login', 'App\Http\Controllers\AuthController@login');
Route::post('/logout', 'App\Http\Controllers\AuthController@logout')->middleware('auth:sanctum');



Route::middleware(['super-admin', 'throttle'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('users', UserController::class);
});

//Route::get('/export-categories', 'App\Http\Controllers\CategoryController@exportCategories');
Route::get('/export-categories', [CategoryController::class, 'exportCategories']);
Route::post('/import-categories', [CategoryController::class, 'importCategories']);
