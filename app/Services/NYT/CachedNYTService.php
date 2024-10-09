<?php

declare(strict_types=1);

namespace App\Services\NYT;

use App\DTOs\BestSellersOptions;
use App\Services\NYT\Contracts\NYTServiceInterface;
use App\ValueObjects\CacheDuration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Throwable;

class CachedNYTService implements NYTServiceInterface
{
    public function __construct(
        private readonly NYTServiceInterface $nytService,
        private readonly CacheDuration $cacheDuration
    ) {}

    public function bestSellers(BestSellersOptions $options): array
    {
        $cacheKey = $this->generateCacheKey($options);

        $cachedData = Cache::get($cacheKey);

        if ($cachedData !== null) {

            Log::info('Using data from cache', ['cache_key' => $cacheKey]);

            return $cachedData;
        }

        // If not in cache, fetch fresh data
        try {
            $freshData = $this->nytService->bestSellers($options);

            Cache::put($cacheKey, $freshData, $this->cacheDuration->inSeconds());

            Log::info('Cached fresh NYT best sellers data', ['cache_key' => $cacheKey]);

            return $freshData;
        } catch (Throwable $e) {
            Log::error('Error fetching NYT best sellers', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    private function generateCacheKey(BestSellersOptions $options): string
    {
        return 'nyt_bestsellers_'.md5(serialize($options));
    }
}
