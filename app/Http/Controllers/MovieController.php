<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use App\Repositories\Contracts\MovieRepositoryInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    use ApiResponse;
    public function __construct(private MovieRepositoryInterface $movieRepository)
    {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters=  $request->only(['search','year','min_rating','genre_id']);
        $sortBy = $request->input('sort_by','title');
        $order = $request->input('order','asc');
        $movies = $this->movieRepository->filter($filters,$sortBy,$order);
        return $this->successResponse(MovieResource::collection($movies));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovieRequest $request)
    {
        $movie = $this->movieRepository->create($request->safe()->except('genre_ids'));
        if($request->has('genre_ids'))
            {
                $this->movieRepository->syncGenres($movie, $request->genre_ids);
            }
        $movie->load('genres');
        return $this->successResponse(new MovieResource($movie),"Película creada exitosamente.", 201);
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

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        $movie = $this->movieRepository->update($movie, $request->safe()->except('genre_ids'));
        if($request->has('genre_ids'))
            {
                $this->movieRepository->syncGenres($movie, $request->genre_ids);
            }
        $movie->load('genres');
        return $this->successResponse(new MovieResource($movie),"Película actualizada exitosamente.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        $this->movieRepository->delete($movie);
        return response()->noContent();
    }
}
