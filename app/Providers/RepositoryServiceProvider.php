<?php

namespace App\Providers;

use App\Repositories\Contracts\GenreRepositoryInterface;
use App\Repositories\Eloquent\GenreRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(GenreRepositoryInterface::class, GenreRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}