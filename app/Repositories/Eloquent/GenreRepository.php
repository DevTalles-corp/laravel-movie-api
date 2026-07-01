<?php

namespace App\Repositories\Eloquent;

use App\Models\Genre;
use App\Repositories\Contracts\GenreRepositoryInterface;

class GenreRepository extends BaseRepository implements GenreRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(Genre $model)
    {
        parent::__construct($model);
    }
}