<?php

use App\Http\Controllers\Metrics\MetricOrdersController;
use App\Http\Controllers\Order\listAllOrdersController;
use Illuminate\Support\Facades\Route;

Route::middleware('is_admin')->prefix('metrics/orders')->group(function () {
  Route::get('/listMetrics', MetricOrdersController::class);
  
});

Route::middleware('is_admin')->prefix('order')->group(function(){
  Route::get('/allOrders',listAllOrdersController::class);
});