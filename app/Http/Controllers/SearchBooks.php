<?php

namespace App\Http\Controllers;

use App\Http\Requests\BestSellersRequest;
use App\Services\NYT\Contracts\NYTServiceInterface;

class SearchBooks extends Controller
{
    public function __invoke(BestSellersRequest $request, NYTServiceInterface $nytService)
    {

        $bestSellers = $nytService->bestSellers($request->toDTO());

        return response()->json($bestSellers);
    }
}
