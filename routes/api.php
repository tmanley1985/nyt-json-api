<?php

use App\Http\Controllers\SearchBooks;
use Illuminate\Support\Facades\Route;

Route::get('/1/nyt/best-sellers', SearchBooks::class);
