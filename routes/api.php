<?php

use App\Http\Controllers\SearchBooks;
use Illuminate\Support\Facades\Route;

// TODO: Put the service behind an interface and bind this to a config value.
Route::get('/1/nyt/best-sellers', SearchBooks::class);
