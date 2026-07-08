<?php

namespace App\Providers;

use App\Repositories\Contracts\GenreRepositoryInterface;
use App\Repositories\Contracts\MovieRepositoryInterface;
use App\Repositories\Eloquent\GenreRepository;
use App\Repositories\Eloquent\MovieRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(GenreRepositoryInterface::class, GenreRepository::class);
        $this->app->bind(MovieRepositoryInterface::class, MovieRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
