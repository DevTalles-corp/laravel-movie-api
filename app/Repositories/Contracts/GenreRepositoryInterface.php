<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface GenreRepositoryInterface extends BaseRepositoryInterface
{
   public function filter(
    array $filters,
    string $sortBy = 'name',
    string $order = 'asc'
   ):Collection;

   public function findBySlugOrFail(string $slug):Model;

   public function restore(int $id): Model;
}
