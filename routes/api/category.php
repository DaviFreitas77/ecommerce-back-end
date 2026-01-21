<?php

use App\Http\Controllers\Category\CreateCategory;
use App\Http\Controllers\Category\ListCategoryController;
use Illuminate\Support\Facades\Route;

Route::middleware('is_admin')->prefix('category')->group(function () {
Route::post('/create', CreateCategory::class);
});

Route::prefix('category')->group(function () {
Route::get('/list', ListCategoryController::class);
});