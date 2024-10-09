<?php

declare(strict_types=1);

namespace App\Services\NYT;

use App\DTOs\BestSellersOptions;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class NYTService {

    public function __construct(
        private readonly string $apiKey,
        private readonly string $uri,
    ) {}

    public function bestSellers(BestSellersOptions $options)
    {
        $response = Http::get(
            "{$this->uri}/lists/best-sellers/history.json", [
                "api-key" => $this->apiKey,
                ...$options->toArray(),
            ]);

        if ($response->status() === 401) {
            
            Log::error('NYT API unauthorized access or invalid API key', [
                'response' => $response->body(),
            ]);
    
            throw new HttpResponseException(response()->json([
                'error' => 'Unauthorized access. Please try again later.',
            ], 401));
        }
            
        return $response->throw()->json();
    }
}