<?php

use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\CarStatusController;
use App\Http\Controllers\API\MovieController;
use App\Http\Controllers\API\MovieGenreController;
use App\Http\Controllers\API\MusicController;
use App\Http\Controllers\API\SingerController;
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

Route::get('genres', [MovieGenreController::class, 'all']);
Route::get('movies', [MovieController::class, 'getAll']);

Route::get('status', [CarStatusController::class, 'all']);
Route::post('status', [CarStatusController::class, 'perbarui']);

Route::get('articles', [ArticleController::class, 'all']);

Route::get('singers', [SingerController::class, 'all']);
Route::get('musics', [MusicController::class, 'all']);
