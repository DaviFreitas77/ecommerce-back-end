<?php

use App\Http\Controllers\Order\CreateOrderController;
use App\Http\Controllers\Order\LatestOrderUserController;
use App\Http\Controllers\Order\ListOrderUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('order')->group(function () {
  Route::post('/create', CreateOrderController::class);
  Route::get('/listOrderUser', ListOrderUserController::class);
  Route::get('/latestOrder',LatestOrderUserController::class);
});