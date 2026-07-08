<?php

namespace App\Http\Controllers;

use App\Http\Resources\MovieResource;
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
