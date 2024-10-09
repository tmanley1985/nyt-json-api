<?php

declare(strict_types=1);

namespace App\Services\NYT;

use App\DTOs\BestSellersOptions;
use Illuminate\Support\Facades\Http;

class NYTService {

    public function __construct(
        private readonly string $apiKey,
        private readonly string $uri,
    ) {}

    public function bestSellers(BestSellersOptions $options)
    {
        return Http::get(
            "{$this->uri}/lists/best-sellers/history.json", [
                "api-key" => $this->apiKey,
                ...$options->toArray(),
            ])->throw()->json('results');
    }
}