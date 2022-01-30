<?php

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

Route::post('/login', [App\Http\Controllers\Api\Auth\AuthController::class,'authenticate']);
Route::post('/register', [App\Http\Controllers\Api\Auth\AuthController::class,'register']);

Route::group(['middleware' => 'auth:sanctum'], function() {
//    Route::post('/logout', [App\Http\Controllers\Api\Auth\AuthController::class,'logout']);
    Route::get('/auth/user', function (Request $request) {
        return ['data' => $request->user()];
    });
    Route::resource('products', \App\Http\Controllers\Api\ProductsController::class);
});
Route::middleware('auth:sanctum')->post('/logout', [App\Http\Controllers\Api\Auth\AuthController::class,'logout']);

Route::resource('categories', \App\Http\Controllers\Api\CategoriesController::class);
/*//Route::resource( 'categories', \App\Http\Controllers\Api\CategoriesController::class, ['only' => ['store']]);
//Route::resource('products', \App\Http\Controllers\Api\ProductsController::class)->only('index');
//Route::resource('products', \App\Http\Controllers\Api\ProductsController::class)->except(['update']);
//Route::post('products/{id}', [\App\Http\Controllers\Api\ProductsController::class, 'update']);*/
