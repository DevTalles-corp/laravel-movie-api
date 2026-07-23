<?php

namespace App\Repositories\Eloquent;

use App\Models\Genre;
use App\Models\Movie;
use App\Repositories\Contracts\MovieRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class MovieRepository extends BaseRepository implements MovieRepositoryInterface
{
    private const SORTABLE = ['title', 'rating', 'created_at'];

    /**
     * Create a new class instance.
     */
    public function __construct(Movie $model)
    {
        parent::__construct($model);
    }

    /**
     * @inheritDoc
     */
    public function filter(array $filters, string $sortBy = 'title', string $order = 'asc'): Collection
    {
        $key = 'movies.index.'.md5(serialize(compact('filters', 'sortBy', 'order')));
        $json = Cache::remember($key, now()->addMinutes(30), function () use ($filters, $sortBy, $order) {
            $query = Movie::with('genres');
            $query->when($filters['search'] ?? null, function ($q, $search) {
                return $q->whereRaw('LOWER(title) LIKE ?', ['%'.strtolower($search).'%']);
            });

            $query->when($filters['year'] ?? null, function ($q, $year) {
                return $q->where('year', $year);
            });

            $query->when($filters['min_rating'] ?? null, function ($q, $minRating) {
                return $q->where('rating', '>=', $minRating);
            });

            $query->when($filters['genre_id'] ?? null, function ($q, $genreId) {
                return $q->whereHas('genres', function ($subQuery) use ($genreId) {
                    $subQuery->where('genres.id', $genreId);
                });
            });
            $sortColumn = in_array($sortBy, self::SORTABLE) ? $sortBy : 'title';
            $order = $order === 'desc' ? 'desc' : 'asc';

            return $query->orderBy($sortColumn, $order)->get()->toJson();
        });
        $data = json_decode($json, true);
        $movies = Movie::hydrate($data);
        $movies->each(function (Movie $movie, int $i) use ($data): void {
            unset($movie->genres);
            $movie->setRelation('genres', Genre::hydrate($data[$i]['genres'] ?? []));
        });

        return $movies;
    }

    /**
     * @inheritDoc
     */
    public function syncGenres(Movie $movie, array $genreIds): void
    {
        $movie->genres()->sync($genreIds);
    }
}