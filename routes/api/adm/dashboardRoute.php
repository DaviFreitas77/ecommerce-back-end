<?php

use App\Http\Controllers\Metrics\billingController;
use App\Http\Controllers\Metrics\MetricOrdersController;
use App\Http\Controllers\Notification\SendNotificationController;
use App\Http\Controllers\Order\listAllOrdersController;
use App\Http\Controllers\Product\CreateProductController;
use App\Http\Controllers\Product\DeleteProductController;
use App\Http\Controllers\Product\EditProductController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;


//metrics
Route::middleware(['auth:sanctum','is_admin'])->prefix('metrics')->group(function () {
  Route::get('/listMetrics', MetricOrdersController::class);
  Route::get('/billing', billingController::class);
});

Route::middleware(['auth:sanctum','is_admin'])->prefix('order')->group(function () {
  Route::get('/allOrders', listAllOrdersController::class);
});


Route::middleware(['auth:sanctum','is_admin'])->prefix('prod')->group(function () {
  Route::delete('delProduct/{id}', DeleteProductController::class);
  Route::post('/registerProduct', CreateProductController::class);
  Route::patch('/editProduct',EditProductController::class);
});

Route::prefix('notification')->group(function(){
  Route::get('/welcome', SendNotificationController::class);
});