<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class HealthController extends Controller
{
    public function index():JsonResponse
    {
        return response()->json(["status"=>"OKI", "app"=>"MovieAPI"]);
    }
}
