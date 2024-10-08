<?php

declare(strict_types=1);

namespace App\Services\NYT;

class NYTService {
    public function __construct(
        private readonly string $apiKey,
        private readonly string $uri,
    ) {}
}