<?php

use App\Http\Controllers\Color\createColorController;
use App\Http\Controllers\Color\ListColorController;
use Illuminate\Support\Facades\Route;

Route::prefix('color')->group(function(){
  Route::post('/create',createColorController::class);
  Route::get('/list',ListColorController::class);
});