<?php

namespace App\Providers;

use App\Services\NYT\CachedNYTService;
use App\Services\NYT\Contracts\NYTServiceInterface;
use App\Services\NYT\NYTService;
use App\ValueObjects\CacheDuration;
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

        // So here we're going to bind this interface to the CachedNYTService
        // and we'll maintain a read-through cache here with a basic ttl cache invalidation.
        $this->app->bind(NYTServiceInterface::class, function ($app) {
            return new CachedNYTService(
                $app->make(NYTService::class),
                new CacheDuration(config('services.nyt.cache_minutes', 60))
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
