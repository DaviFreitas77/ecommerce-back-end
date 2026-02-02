<?php

use App\Http\Controllers\User\UpdateUserController;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\GoogleCallbackController;
use App\Http\Controllers\Auth\GoogleRedirectController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Filter\filterSubCategoryController;
use App\Http\Controllers\Upload\UploadController;
use App\Http\Controllers\User\RegisterNewLetterController;
use App\Mail\MailOrderCreated;
use Illuminate\Support\Facades\Mail;

require __DIR__ . '/api/category.php';
require __DIR__ . '/api/order.php';
require __DIR__ . '/api/color.php';
require __DIR__ . '/api/cupom.php';
require __DIR__ . '/api/logradouro.php';
require __DIR__ . '/api/mercadoPago.php';
require __DIR__ . '/api/product.php';
require __DIR__ . '/api/size.php';
require __DIR__ . '/api/shoppingCart.php';
require __DIR__ . '/api/subCategory.php';
require __DIR__ . '/api/adm/dashboardRoute.php';




Route::prefix('auth')->group(function () {
  Route::post('/register', RegisterController::class);
  Route::post('/login', LoginController::class);
  Route::get('google/redirect', GoogleRedirectController::class);
  Route::get('google/callback', GoogleCallbackController::class);

  Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', LogoutController::class);
    Route::get('/profile', ProfileController::class);
  });
});

Route::prefix('user')->group(function () {
  Route::patch('/update', UpdateUserController::class);
  Route::patch('/registerNewsLetter', RegisterNewLetterController::class);
})->middleware('auth:sanctum');

Route::post('/upload-image', UploadController::class);

Route::prefix('filter')->group(function(){
  Route::get('/filterSubCategory/{nameSubCategory}',filterSubCategoryController::class);
});