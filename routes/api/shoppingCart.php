<?php

use App\Http\Controllers\Shopping\AddProductInCart;
use App\Http\Controllers\Shopping\GetCartController;
use App\Http\Controllers\Shopping\SyncCartController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')
    ->prefix('shoppingCart')
    ->group(function () {
        Route::post('/add', AddProductInCart::class);
        Route::post('/sync', SyncCartController::class);
        Route::get('/getCart', GetCartController::class);
    });