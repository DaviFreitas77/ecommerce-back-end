<?php

use App\Http\Controllers\Product\CreateProductController;
use App\Http\Controllers\Product\DeleteProductController;
use App\Http\Controllers\Product\ListProductByCategoryController;
use App\Http\Controllers\Product\ListProductByIdController;
use App\Http\Controllers\Product\ListProductController;
use App\Http\Controllers\Product\SearchProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('prod')->group(function(){
Route::get('/productsByCategory/{id}',ListProductByCategoryController::class);


  Route::get('/products',ListProductController::class);
  Route::get('/product/{id}',ListProductByIdController::class);
  Route::get('/search/{search}',SearchProductController::class);
  

  //prefixo de admin

  Route::delete('delProduct/{id}',DeleteProductController::class);
  Route::post('/registerProduct',CreateProductController::class);
  
});