<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGenreRequest;
use App\Http\Requests\UpdateGenreRequest;
use App\Http\Resources\GenreResource;
use App\Models\Genre;
use App\Repositories\Contracts\GenreRepositoryInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    use ApiResponse;

    public function __construct(private GenreRepositoryInterface $genres){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genres = $this->genres->all();
        return $this->successResponse(GenreResource::collection($genres));
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
