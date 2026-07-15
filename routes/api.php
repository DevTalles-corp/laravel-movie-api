<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

// /api/health
Route::get('/health', HealthController::class);

Route::apiResource('genres', GenreController::class);

Route::apiResource('movies', MovieController::class);

Route::get('/genres/slug/{slug}', [GenreController::class, 'showBySlug']);

Route::post('/genres/{id}/restore', [GenreController::class, 'restore']);

// Públicas
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});
// Protegidas
Route::prefix('auth:api')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});

