<?php

namespace App\Repositories\Eloquent;

use App\Models\Movie;
use App\Repositories\Contracts\MovieRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class MovieRepository extends BaseRepository implements MovieRepositoryInterface
{
    private const SORTABLE = ['title','rating','created_at'];
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
    public function filter(array $filters, string $sortBy = 'title', string $order = 'asc'): Collection {
        $query = Movie::with('genres');
        $query->when($filters['search'] ?? null,function($q, $search)
        {
            return $q->whereRaw('LOWER(title) LIKE ?',['%'.strtolower($search).'%']);
        });

        $query->when($filters['year'] ?? null,function($q, $year)
        {
            return $q->where('year',$year);
        });

        $query->when($filters['min_rating'] ?? null,function($q, $minRating)
        {
            return $q->where('rating','>=', $minRating);
        });

         $query->when($filters['genre_id'] ?? null,function($q, $genreId)
        {
            return $q->whereHas('genres',function($subQuery) use ($genreId)
            {
                $subQuery->where('genres.id',$genreId);
            });
        });
        $sortColumn = in_array($sortBy, self::SORTABLE) ? $sortBy : 'title';
        $order = $order === 'desc'? 'desc':'asc';


        return $query->orderBy($sortColumn,$order)->get();
    }

    /**
     * @inheritDoc
     */
    public function syncGenres(Movie $movie, array $genreIds): void {
        $movie->genres()->sync($genreIds);
    }
}
