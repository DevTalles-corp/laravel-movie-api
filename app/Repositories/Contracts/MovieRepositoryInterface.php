<?php

namespace App\Repositories\Contracts;

use App\Models\Movie;
use Illuminate\Pagination\LengthAwarePaginator;

interface MovieRepositoryInterface extends BaseRepositoryInterface
{
    public function filter(
        array $filters,
        string $sortBy = 'title',
        string $order = 'asc',
        int $perPage = 15,
    ): LengthAwarePaginator;

    public function syncGenres(Movie $movie, array $genreIds): void;
}