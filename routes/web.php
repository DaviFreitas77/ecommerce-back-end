<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleCallbackController;
use App\Http\Controllers\Auth\GoogleRedirectController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisterController;


Route::prefix('auth')->group(function () {
  Route::post('/register', RegisterController::class);
  Route::post('/login', LoginController::class);
  Route::get('google/redirect', GoogleRedirectController::class);
  Route::get('google/callback', GoogleCallbackController::class);
  
  Route::middleware('auth:web')->group(function(){
    Route::post('/logout', LogoutController::class);
    Route::get('/profile',ProfileController::class);
  });
});







Route::get('/{any}', function () {
    return file_get_contents(public_path('index.html'));
})->where('any', '.*');