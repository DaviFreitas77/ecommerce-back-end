<?php

use App\Http\Controllers\Color\CreateColorController;
use App\Http\Controllers\Color\ListColorController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum','is_admin'])->prefix('color')->group(function(){
  Route::post('/create',CreateColorController::class);
  Route::get('/list',ListColorController::class);
});