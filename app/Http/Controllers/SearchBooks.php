<?php

namespace App\Http\Controllers;

use App\Http\Requests\BestSellersRequest;
use App\Services\NYT\NYTService;

class SearchBooks extends Controller
{
    public function __invoke(BestSellersRequest $request, NYTService $nytService)
    {

        $bestSellers = $nytService->bestSellers($request->toDTO());

        return response()->json($bestSellers);
    }
}
