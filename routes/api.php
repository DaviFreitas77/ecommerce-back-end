<?php



use App\Http\Controllers\ProductShoppingController;
use App\Http\Controllers\shoppingCartController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\User\UpdateUserController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;
use Stripe\ApiOperations\Update;

require __DIR__ . '/api/category.php';
require __DIR__ . '/api/order.php';
require __DIR__ . '/api/color.php';
require __DIR__ . '/api/cupom.php';
require __DIR__ . '/api/logradouro.php'; 
require __DIR__ . '/api/mercadoPago.php';
require __DIR__ . '/api/product.php';
require __DIR__ . '/api/size.php';
require __DIR__ . '/api/shoppingCart.php';

Route::prefix('user')->group(function () {
    Route::patch('/update', UpdateUserController::class);
})->middleware('auth:sanctum');