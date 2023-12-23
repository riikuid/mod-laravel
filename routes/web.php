<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CarStatusController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\MovieGenreController;
use App\Http\Controllers\MovieItemController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\SingerController;
use App\Http\Controllers\SingerDetailController;
use App\Models\MusicArtist;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/public/article/{namagambar}', function ($namagambar) {
    return '/storage/article/' . $namagambar;
});

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::name('dashboard.')->prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::resource('genre', MovieGenreController::class);
        Route::resource('movie', MovieController::class);
        Route::resource('article', ArticleController::class);
        Route::resource('movie.detail', MovieItemController::class)->shallow()->only([
            'index', 'create', 'store', 'destroy'
        ]);;
        Route::resource('car-status', CarStatusController::class)->shallow()->only([
            'index', 'edit', 'update'
        ]);
        Route::resource('singer', SingerController::class);
        Route::resource('music', MusicController::class);
        Route::resource('singer.detail', SingerDetailController::class);
        // Route::post('artist.destroy-music', MusicArtistController::class, 'destroyMusic');
    });
});
