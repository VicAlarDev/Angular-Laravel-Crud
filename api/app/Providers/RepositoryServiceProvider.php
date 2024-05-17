<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\EmpleadoRepository;
use App\Interfaces\EmpleadoRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(EmpleadoRepositoryInterface::class, EmpleadoRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
