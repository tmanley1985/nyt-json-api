<?php

namespace App\Http\Controllers;

use App\Services\NYT\NYTService;
use App\Http\Requests\BestSellersRequest;

class SearchBooks extends Controller
{

    public function __invoke(BestSellersRequest $request, NYTService $nytService)
    {

        $bestSellers = $nytService->bestSellers($request->toDTO());

        return response()->json($bestSellers);
    }
}
