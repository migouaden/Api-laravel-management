<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

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


//public routes
Route::get('/users', [AuthController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/articles/{id}', [ArticleController::class, 'show']);

Route::get('/search/products/{name}', [ProductController::class, 'search']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/roles', [AuthController::class, 'getRoles']);


//private routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    //Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    //Api Management Products By Writer
    Route::group(['middleware' => ['role:bayer']], function () {
        Route::post('/create/products', [ProductController::class, 'store']);
        Route::post('/update/products/{id}', [ProductController::class, 'update']);
        Route::delete('/delete/products/{id}', [ProductController::class, 'destroy']);
    });

    //Api Management Articles By Writer
    Route::group(['middleware' => ['role:writer']], function () {
        Route::post('/create/article', [ArticleController::class, 'store']);
        Route::post('/update/article/{id}', [ArticleController::class, 'update']);
        Route::delete('/delete/article/{id}', [ArticleController::class, 'destroy']);
    });
});

//Get Articles using Carbon Date 
Route::get('/todayarticle', [ArticleController::class, 'GetTodayArticle']);
Route::get('/weekarticle', [ArticleController::class, 'GetLastWeekArticle']);
Route::get('/montharticle', [ArticleController::class, 'GetLastMounthArticle']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
