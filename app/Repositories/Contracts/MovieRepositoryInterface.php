<?php

namespace App\Repositories\Contracts;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;

interface MovieRepositoryInterface extends BaseRepositoryInterface
{
    public function filter(
    array $filters,
    string $sortBy = 'title',
    string $order = 'asc'
   ):Collection;

   public function syncGenres(Movie $movie, array $genreIds):void;
}
