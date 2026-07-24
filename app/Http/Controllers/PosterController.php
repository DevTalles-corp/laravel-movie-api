<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePosterRequest;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PosterController extends Controller
{
    use ApiResponse;

    public function store(StorePosterRequest $request, Movie $movie): JsonResponse
    {
        if ($movie->poster && Storage::disk('public')->exists($movie->poster)) {
            Storage::disk('public')->delete($movie->poster);
        }
        $path = $request->file('poster')->store('posters', 'public');
        $movie->update(['poster' => $path]);

        return $this->successResponse(new MovieResource($movie->load('genres')), 'Póster actualizado exitosamente.');
    }
}
