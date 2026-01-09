<?php

use App\Http\Controllers\auth\GoogleCallbackController;
use App\Http\Controllers\auth\GoogleRedirectController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\LogoutController;
use App\Http\Controllers\auth\ProfileController;
use App\Http\Controllers\auth\RegisterController;

use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
  Route::post('/register', RegisterController::class);
  Route::post('/login', LoginController::class);
  Route::get('google/redirect', GoogleRedirectController::class);
  Route::get('google/callback', GoogleCallbackController::class);
  
  Route::middleware('auth')->group(function(){
    Route::post('/logout', LogoutController::class);
    Route::get('/profile',ProfileController::class);
  });
});