<?php

use Illuminate\Support\Facades\Route;

// /api/health
Route::get('/health', function () {
    return response()->json(["status"=>"OK", "app"=>"MovieAPI"]);
});
