<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->post('/logout', 'App\Http\Controllers\API\AuthController@logout');
Route::middleware('auth:sanctum')->post('/produk', 'App\Http\Controllers\API\ProdukController@create');
Route::middleware('auth:sanctum')->get('/produk', 'App\Http\Controllers\API\ProdukController@index');
Route::middleware('auth:sanctum')->put('/produk/{id}', 'App\Http\Controllers\API\ProdukController@update');
Route::middleware('auth:sanctum')->delete('/produk/{id}', 'App\Http\Controllers\API\ProdukController@delete');
Route::middleware('auth:sanctum')->get('/produk/{id}', 'App\Http\Controllers\API\ProdukController@getProdukById');



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
