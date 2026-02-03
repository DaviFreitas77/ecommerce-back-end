<?php

use App\Http\Controllers\Size\CreateSizeController;
use App\Http\Controllers\Size\ListSizeController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum','is_admin'])->prefix('size')->group(function(){
Route::get('/list', ListSizeController::class);
Route::post('/registerSize',CreateSizeController::class);
});