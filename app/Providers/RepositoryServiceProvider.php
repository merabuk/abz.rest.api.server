<?php

namespace App\Providers;

use App\Interfaces\PositionRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\PositionRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PositionRepositoryInterface::class, PositionRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
