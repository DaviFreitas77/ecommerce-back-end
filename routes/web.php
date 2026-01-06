<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;


Route::prefix('auth')->group(function () {
    Route::post('/register', [UserController::class, 'createUser']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/google/redirect', [UserController::class, 'redirectToGoogle']);
    Route::get('/google/callback', [UserController::class, 'handleGoogleCallback']);
});