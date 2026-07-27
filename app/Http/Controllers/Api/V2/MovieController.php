<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\MovieResource;
use App\Repositories\Contracts\MovieRepositoryInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    use ApiResponse;

    public function __construct(
        private MovieRepositoryInterface $movieRepository
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = max(1, min(50, $request->input('per_page', 15)));
        $filters = $request->only(['search', 'year', 'min_rating', 'genre_id']);
        $sortBy = $request->input('sort_by', 'title');
        $order = $request->input('order', 'asc');
        $movies = $this->movieRepository->filter($filters, $sortBy, $order, $perPage);

        return MovieResource::collection($movies);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $movie = $this->movieRepository->findOrFail($id);
        $movie->load('genres');

        return $this->successResponse(new MovieResource($movie));
    }
}