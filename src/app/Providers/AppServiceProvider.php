<?php

namespace App\Providers;

use App\Interfaces\ActivityServiceInterface;
use App\Services\ActivityService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(ActivityServiceInterface::class, ActivityService::class);
    }
}
