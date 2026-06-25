<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGenreRequest;
use App\Http\Requests\UpdateGenreRequest;
use App\Http\Resources\GenreResource;
use App\Models\Genre;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genres = Genre::all();
        return $this->successResponse(GenreResource::collection($genres));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGenreRequest $request)
    {
       $genre = Genre::create($request->validated());
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
        $genre->update($request->validated());
        return $this->successResponse(new GenreResource($genre),"Genero actualizado exitosamente.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
       $genre->delete();
       return $this->successResponse(null,"Género eliminado exitosamente.");
    }
}
