<?php

namespace App\Observers;

use App\Models\Movie;
use Illuminate\Support\Facades\Cache;

class MovieObserver
{
    /**
     * Handle the Movie "created" event.
     */
    public function created(Movie $movie): void
    {
        $this->flush();
    }

    /**
     * Handle the Movie "updated" event.
     */
    public function updated(Movie $movie): void
    {
        $this->flush();
    }

    /**
     * Handle the Movie "deleted" event.
     */
    public function deleted(Movie $movie): void
    {
        $this->flush();
    }

    private function flush(): void
    {
        Cache::flush();
    }
}
