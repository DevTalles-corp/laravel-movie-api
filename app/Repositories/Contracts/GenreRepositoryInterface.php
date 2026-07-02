<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface GenreRepositoryInterface extends BaseRepositoryInterface
{
   public function filter(
    array $filters,
    string $sortBy = 'name',
    string $order = 'asc'
   ):Collection;
}
