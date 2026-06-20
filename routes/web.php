<?php

use App\Http\Controllers\ItemSearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/search', [ItemSearchController::class, 'index'])->name('search');
