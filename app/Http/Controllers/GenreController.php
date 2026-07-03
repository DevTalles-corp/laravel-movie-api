<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGenreRequest;
use App\Http\Requests\UpdateGenreRequest;
use App\Http\Resources\GenreResource;
use App\Models\Genre;
use App\Repositories\Contracts\GenreRepositoryInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Request as HttpRequest;

class GenreController extends Controller
{
    use ApiResponse;

    public function __construct(private GenreRepositoryInterface $genres){}
    /**
     * Display a listing of the resource.
     */
    public function index(HttpRequest $request)
    {
        $genres = $this->genres->filter(
            filters: $request->only(['search','is_active']),
            sortBy: $request->input('sort_by','name'),
            order: $request->input('order','asc'),
        );
        return $this->successResponse(GenreResource::collection($genres));
    }

    public function showBySlug(string $slug):JsonResponse
    {
        $genre = $this->genres->findBySlugOrFail($slug);
        return $this->successResponse( new GenreResource($genre));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGenreRequest $request)
    {
       $genre = $this->genres->create($request->validated());
       return $this->successResponse(new GenreResource($genre),
               "Género creado exitosamente.",201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
       return $this->successResponse(new GenreResource($genre));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGenreRequest $request, Genre $genre)
    {
        $this->genres->update($genre, $request->validated());
        return $this->successResponse(new GenreResource($genre),"Genero actualizado exitosamente.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
       $this->genres->delete($genre);
       return $this->successResponse(null,"Género eliminado exitosamente.");
    }
}
