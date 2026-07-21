<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

// Públicas
// /api/health
Route::get('/health', HealthController::class);

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});
// Géneros
Route::get('/genres', [GenreController::class, 'index']);
Route::get('/genres/slug/{slug}', [GenreController::class, 'showBySlug']);
Route::get('/genres/{genre}', [GenreController::class, 'show']);

// Movies
Route::get('/movies', [MovieController::class, 'index']);
Route::get('/movies/{movie}', [MovieController::class, 'show']);

// Protegidas
Route::middleware('auth:api')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
    });
    // Géneros
    Route::middleware('role:admin,editor')->group(function () {
        Route::post('genres', [GenreController::class, 'store']);
        Route::put('genres/{genre}', [GenreController::class, 'update']);
        Route::patch('genres/{genre}', [GenreController::class, 'update']);
    });
    Route::middleware('role:admin')->group(function () {
        Route::delete('genres/{genre}', [GenreController::class, 'destroy']);
        Route::post('/genres/{id}/restore', [GenreController::class, 'restore']);
    });

    // Películas
    Route::middleware('role:admin,editor')->group(function () {
        Route::post('movies', [MovieController::class, 'store']);
        Route::put('movies/{movie}', [MovieController::class, 'update']);
        Route::patch('movies/{movie}', [MovieController::class, 'update']);
    });
    Route::middleware('role:admin')->group(function () {
        Route::delete('movies/{movie}', [MovieController::class, 'destroy']);
    });
});