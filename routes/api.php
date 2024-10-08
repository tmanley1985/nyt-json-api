<?php

use App\Services\NYT\NYTService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/1/nyt/best-sellers', function (Request $request, NYTService $nytService) {
    return response()->json('JHI');
});
