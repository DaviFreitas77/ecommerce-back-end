<?php

use App\Http\Controllers\Category\CreateCategory;
use App\Http\Controllers\Category\ListCategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('category')->group(function () {
  Route::post('/create', CreateCategory::class);
  Route::get('/list', ListCategoryController::class);
});