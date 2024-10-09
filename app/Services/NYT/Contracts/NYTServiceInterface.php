<?php

declare(strict_types=1);

namespace App\Services\NYT\Contracts;

use App\DTOs\BestSellersOptions;

interface NYTServiceInterface
{
    public function bestSellers(BestSellersOptions $options);
}
