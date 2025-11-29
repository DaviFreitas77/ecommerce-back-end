<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;


Route::prefix('auth')->group(function () {
    Route::post('/register', [UserController::class, 'createUser']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/loginGoogle', [UserController::class, 'LoginGoogle']);
});
