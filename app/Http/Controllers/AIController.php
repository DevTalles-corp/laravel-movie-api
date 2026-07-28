<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecommendationsRequest;
use App\Models\Movie;
use App\Services\AI\MovieAIService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AIController extends Controller
{
    use ApiResponse;

    public function __construct(
        private MovieAIService $movieAIService
    ) {}

    public function generateSynopsis(Movie $movie): JsonResponse
    {
        try {
            $synopsis = $this->movieAIService->generateSynopsis($movie->load('genres'));
        } catch (\Throwable $th) {
            $this->errorResponse('Error al generar la sinopsis.'.$th->getMessage(), 502);
        }

        return $this->successResponse(['synopsis' => $synopsis], 'Sinopsis generada exitosamente.');
    }

    public function recommendations(RecommendationsRequest $request): JsonResponse
    {
        try {
            $recommendations = $this->movieAIService->getRecomendations($request->validated('genres'));
        } catch (\Throwable $th) {
            $this->errorResponse('Error al obtener recomendaciones.'.$th->getMessage(), 502);
        }

        return $this->successResponse(['recommendations' => $recommendations], 'Recomendaciones generadas exitosamente. ');
    }
}
