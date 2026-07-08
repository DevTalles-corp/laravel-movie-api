<?php

use App\Http\Controllers\GenreController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

// /api/health
Route::get('/health', HealthController::class);

Route::apiResource('genres', GenreController::class);

Route::apiResource('movies', MovieController::class);

Route::get("/genres/slug/{slug}", [GenreController::class, 'showBySlug']);

Route::post("/genres/{id}/restore", [GenreController::class, 'restore']);