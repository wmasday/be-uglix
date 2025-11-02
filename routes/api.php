<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\ActorController;
use App\Http\Controllers\MovieCastController;
use App\Http\Controllers\DropdownController;
use Illuminate\Support\Facades\Route;



// Protected write routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::post('genres', [GenreController::class, 'store']);
    Route::put('genres/{genre}', [GenreController::class, 'update']);
    Route::delete('genres/{genre}', [GenreController::class, 'destroy']);

    Route::get('movies', [MovieController::class, 'index']);
    Route::post('movies', [MovieController::class, 'store']);
    Route::put('movies/{movie}', [MovieController::class, 'update']);
    Route::delete('movies/{movie}', [MovieController::class, 'destroy']);

    Route::post('episodes', [EpisodeController::class, 'store']);
    Route::put('episodes/{episode}', [EpisodeController::class, 'update']);
    Route::delete('episodes/{episode}', [EpisodeController::class, 'destroy']);

    Route::post('actors', [ActorController::class, 'store']);
    Route::put('actors/{actor}', [ActorController::class, 'update']);
    Route::delete('actors/{actor}', [ActorController::class, 'destroy']);

    Route::post('movie-casts', [MovieCastController::class, 'store']);
    Route::put('movie-casts/{movie_id}/{actor_id}', [MovieCastController::class, 'update']);
    Route::delete('movie-casts/{movie_id}/{actor_id}', [MovieCastController::class, 'destroy']);
});

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Public read-only routes
Route::get('genres', [GenreController::class, 'index']);
Route::get('genres/{genre}', [GenreController::class, 'show']);

Route::get('movies', [MovieController::class, 'index']);
Route::get('movies/new-releases', [MovieController::class, 'newReleases']);
Route::get('movies/top-rated', [MovieController::class, 'topRated']);
Route::get('movies/search', [MovieController::class, 'search']);
Route::get('movies/{movie}', [MovieController::class, 'show']);

Route::get('episodes', [EpisodeController::class, 'index']);
Route::get('episodes/{episode}', [EpisodeController::class, 'show']);

Route::get('actors', [ActorController::class, 'index']);
Route::get('actors/{actor}', [ActorController::class, 'show']);
Route::get('actors/{actor}/movies', [ActorController::class, 'movies']);

Route::get('movie-casts', [MovieCastController::class, 'index']);
Route::get('movie-casts/{movie_id}/{actor_id}', [MovieCastController::class, 'show']);

// Dropdown endpoints for navbar (no auth required)
Route::get('dropdown/years', [DropdownController::class, 'getYears']);
Route::get('dropdown/genres', [DropdownController::class, 'getGenres']);
Route::get('dropdown/countries', [DropdownController::class, 'getCountries']);
