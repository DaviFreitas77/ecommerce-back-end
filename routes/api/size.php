<?php

use App\Http\Controllers\Size\CreateSizeController;
use App\Http\Controllers\Size\ListSizeController;
use Illuminate\Support\Facades\Route;

Route::get('/sizes', ListSizeController::class);
Route::post('/registerSize',CreateSizeController::class);