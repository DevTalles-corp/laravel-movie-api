<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class HealthController extends Controller
{
    use ApiResponse;
    public function __invoke():JsonResponse
    {
        return $this->successResponse(["status"=>"OK", "app"=>"MovieAPI"], "Health check");
    }
}
