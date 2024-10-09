<?php

declare(strict_types=1);

namespace App\Services\NYT;

use Illuminate\Support\Facades\Http;

class NYTService {

    public function __construct(
        private readonly string $apiKey,
        private readonly string $uri,
    ) {}

    public function bestSellers()
    {
        // Need to use a builder here.
        return Http::get(
            "{$this->uri}/lists/best-sellers/history.json", [
                "api-key" => $this->apiKey
            ])->json('results');
    }
}