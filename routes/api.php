<?php

use App\Http\Controllers\HealthController;
use Illuminate\Support\Facades\Route;

// /api/health
Route::get('/health', HealthController::class);
