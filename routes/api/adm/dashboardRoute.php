<?php

use App\Http\Controllers\Metrics\billingController;
use App\Http\Controllers\Metrics\MetricOrdersController;
use App\Http\Controllers\Order\listAllOrdersController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;


//metrics
Route::middleware('is_admin')->prefix('metrics')->group(function () {
  Route::get('/listMetrics', MetricOrdersController::class);
  Route::get('/billing', billingController::class);

});

Route::middleware('is_admin')->prefix('order')->group(function(){
  Route::get('/allOrders',listAllOrdersController::class);
});