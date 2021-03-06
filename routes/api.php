<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReviewController;

use App\Models\Book;
//use App\Http\Controllers\ProductController;

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



//Authentication
Route::middleware('auth:sanctum')->group(function (){
    Route::get('user', [AuthController::class,'user']);
    Route::get('logout', [AuthController::class,'logout']);
});
Route::post('login', [AuthController::class,'login']);

Route::post('register', [AuthController::class,'register']);

Route::get('books', [BookController::class,'getAllBooks']);

Route::get('getOnSaleBooks', [BookController::class,'getOnSaleBooks']);
Route::get('getAllAuthors', [BookController::class,'getAllAuthors']);
Route::get('getAllCategories', [BookController::class,'getAllCategories']);
Route::get('book/list-review/{id}', [BookController::class,'getListReviewByID']);
Route::post('book/review/{id}', [ReviewController::class,'update']);


Route::get('getRecommendedBooks', [BookController::class,'getRecommendedBooks']);
Route::get('getPopularBooks', [HomeController::class,'getPopularBooks']);
Route::get('book/{id}', [BookController::class, 'getBookByID']);
//Route::get('book/{id}', [BookController::class, 'getListReviewByBookID']);


Route::apiResource('/', HomeController::class);

//Route::get('books', [BookController::class,'list']);
