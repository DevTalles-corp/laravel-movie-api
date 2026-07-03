<?php

use App\Http\Controllers\GenreController;
use App\Http\Controllers\HealthController;
use Illuminate\Support\Facades\Route;

// /api/health
Route::get('/health', HealthController::class);

Route::apiResource('genres', GenreController::class);

Route::get("/genres/slug/{slug}", [GenreController::class, 'showBySlug']);