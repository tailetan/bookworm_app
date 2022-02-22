<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
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


//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Sanctum
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::middleware('auth:sanctum')->group(function (){
    Route::get('user', [AuthController::class,'user']);
    Route::get('logout', [AuthController::class,'logout']);
});

Route::post('login', [AuthController::class,'login']);
Route::post('register', [AuthController::class,'register']);


Route::get('products', [ProductController::class,'index']);
