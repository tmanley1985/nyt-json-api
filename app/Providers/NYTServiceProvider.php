<?php

namespace App\Providers;

use App\Services\NYT\NYTService;
use Illuminate\Support\ServiceProvider;

class NYTServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(
            NYTService::class,
            fn () => new NYTService(
                apiKey: config('services.nyt.api_key'),
                uri: config('services.nyt.uri'),
            )
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
