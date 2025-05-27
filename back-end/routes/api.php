<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\MovieController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->prefix('movies')->group(function () {
    Route::get('search', [MovieController::class, 'search']);
    Route::get('popular', [MovieController::class, 'popular']);
    Route::get('now-playing', [MovieController::class, 'nowPlaying']);
    Route::get('trending', [MovieController::class, 'trending']);
    Route::get('genres', [MovieController::class, 'genres']);
    Route::get('genre/{genreId}', [MovieController::class, 'byGenre']);
    Route::get('{id}', [MovieController::class, 'show']);
    Route::post('favorite', [MovieController::class, 'favorite']);
    Route::get('favorites', [MovieController::class, 'getFavorites']);
    Route::delete('favorites/{tmdbId}', [MovieController::class, 'unfavorite']);
});
