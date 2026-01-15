<?php
use App\Http\Controllers\User\UpdateUserController;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\GoogleCallbackController;
use App\Http\Controllers\Auth\GoogleRedirectController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisterController;




require __DIR__ . '/api/category.php';
require __DIR__ . '/api/order.php';
require __DIR__ . '/api/color.php';
require __DIR__ . '/api/cupom.php';
require __DIR__ . '/api/logradouro.php'; 
require __DIR__ . '/api/mercadoPago.php';
require __DIR__ . '/api/product.php';
require __DIR__ . '/api/size.php';
require __DIR__ . '/api/shoppingCart.php';







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

Route::prefix('user')->group(function () {
    Route::patch('/update', UpdateUserController::class);
})->middleware('auth:sanctum');