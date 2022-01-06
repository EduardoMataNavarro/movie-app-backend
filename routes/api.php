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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* Movie controller */
Route::get('movie/top-rated', [App\Http\Controllers\MoviesController::class, 'TopRatedMovies']);
Route::get('movie/latest', [App\Http\Controllers\MoviesController::class, 'LatestMovies']);
Route::get('movie/find', [App\Http\Controllers\MoviesController::class, 'FindMovies']);
Route::get('movie/query/{query}', [App\Http\Controllers\MoviesController::class, 'SearchMovie']);
Route::get('movie/{id}', [App\Http\Controllers\MoviesController::class, 'GetMovie']);

/* Genre controller */
Route::get('genre', [App\Http\Controllers\GenreController::class, 'Index']);

/* Language controller */
Route::get('language', [App\Http\Controllers\LanguageController::class, 'Index']);


