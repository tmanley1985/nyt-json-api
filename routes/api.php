<?php

use App\Http\Requests\BestSellersRequest;
use App\Services\NYT\NYTService;
use Illuminate\Support\Facades\Route;

// TODO: Put the service behind an interface and bind this to a config value.
Route::get('/1/nyt/best-sellers', function (BestSellersRequest $request, NYTService $nytService) {
    // dd($nytService->bestSellers());
    // $request->toDTO();
    return response()->json('JHI');
});
