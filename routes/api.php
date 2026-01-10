<?php


use App\Http\Controllers\logradouroController;
use App\Http\Controllers\MCPController;
use App\Http\Controllers\MercadoPagoWebhookController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductShoppingController;
use App\Http\Controllers\shoppingCartController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ZIPCodeController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/api/category.php';
require __DIR__ . '/api/order.php';
require __DIR__ . '/api/color.php';
require __DIR__ . '/api/cupom.php';
require __DIR__ . '/api/logradouro.php'; 
require __DIR__ . '/api/mercadoPago.php';

Route::prefix('user')->group(function () {
    Route::patch('/update', [UserController::class, 'updateUser']);
})->middleware('auth:sanctum');






Route::prefix('prod')->group(function () {
    Route::get('/productsByCategory/{id}', [ProductController::class, 'getProductByCategory']);
    Route::get('/product/{id}', [ProductController::class, 'fetchProductId']);
    Route::get('/products', [ProductController::class, 'fetchProduct']);
    Route::get('/search/{search}', [ProductController::class, 'searchProduct']);
});

//adm


Route::post('/registerSize', [SizeController::class, 'createSize']);


Route::get('/sizes', [SizeController::class, 'fetchSize']);
// Route::get('/recomendatation/{id}', [ProductController::class, 'recomendation']);
Route::delete('delProduct/{id}', [ProductController::class, 'delProduct']);
Route::post('/registerProduct', [ProductController::class, 'createProduct']);




Route::prefix('shoppingCart')->group(function () {
    Route::post('/add', [ProductShoppingController::class, 'addCart']);
    Route::post('/sync', [ProductShoppingController::class, 'syncCart']);
    Route::get('/getCart', [ProductShoppingController::class, 'getCart']);
    Route::get('/getShoppingCart', [shoppingCartController::class, 'shoppingCart']);
})->middleware('auth:sanctum');