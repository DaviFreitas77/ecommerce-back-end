<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\CupomController;
use App\Http\Controllers\logradouroController;
use App\Http\Controllers\MCPController;
use App\Http\Controllers\MercadoPagoWebhookController;
use App\Http\Controllers\orderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductShoppingController;
use App\Http\Controllers\shoppingCartController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ZIPCodeController;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/auth/me', function (Request $request) {
//   return response()->json($request->user());
// });

Route::prefix('user')->group(function () {
    Route::patch('/update', [UserController::class, 'updateUser']);
})->middleware('auth:sanctum');

Route::prefix("logradouro")->group(function () {
    Route::post('/checkZipCode', [ZIPCodeController::class, 'CheckZipCode']);
    Route::post('/logradouro', [logradouroController::class, 'createLogradouro']);
    Route::get('/logradouroUser', [logradouroController::class, 'fetchLogradouro']);
    Route::get('/myLogradouro', [ZIPCodeController::class, 'myAdress']);
    Route::delete('/deleteLogradouro/{id}', [ZIPCodeController::class, 'deleteAdress']);
})->middleware('auth:sanctum');

Route::prefix('order')->group(function () {
    Route::get('/myOrder', [orderController::class, 'fetchOrderUser']);
    Route::get('/latestOrder', [orderController::class, 'latestOrder']);
    Route::post('/createOrder', [orderController::class, 'crateOrder']);
});


Route::prefix('prod')->group(function () {
    Route::get('/productsByCategory/{id}', [ProductController::class, 'getProductByCategory']);
    Route::get('/product/{id}', [ProductController::class, 'fetchProductId']);
    Route::get('/products', [ProductController::class, 'fetchProduct']);
    Route::get('/search/{search}', [ProductController::class, 'searchProduct']);
});

//adm
Route::post('/registerCategory', [CategoryController::class, 'createCategory']);
Route::post('/registerColor', [ColorController::class, 'createColor']);
Route::post('/registerSize', [SizeController::class, 'createSize']);
Route::get('/categories', [CategoryController::class, 'fetchCategory']);
Route::get('/colors', [ColorController::class, 'fetchColor']);
Route::get('/sizes', [SizeController::class, 'fetchSize']);
// Route::get('/recomendatation/{id}', [ProductController::class, 'recomendation']);
Route::delete('delProduct/{id}', [ProductController::class, 'delProduct']);
Route::post('/registerProduct', [ProductController::class, 'createProduct']);
Route::post('/createCupom', [CupomController::class, 'createCupom']);



Route::prefix('shoppingCart')->group(function () {
    Route::post('/add', [ProductShoppingController::class, 'addCart']);
    Route::post('/sync', [ProductShoppingController::class, 'syncCart']);
    Route::get('/getCart', [ProductShoppingController::class, 'getCart']);
    Route::get('/getShoppingCart', [shoppingCartController::class, 'shoppingCart']);
})->middleware('auth:sanctum');


Route::prefix('mcp')->group(function () {
    Route::post('/createPreference', [MCPController::class, 'createPreference']);
    Route::post('/proccessPayment', [MCPController::class, 'proccessPayment']);
    Route::post('/proccessPaymentPix', [MCPController::class, 'proccessPaymentPix']);
    Route::post('/webhook', [MercadoPagoWebhookController::class, 'handle']);
})->middleware('auth:sanctum');


Route::prefix('checkout')->group(function () {
    Route::post('/useCupom', [CupomController::class, 'useCupom']);
})->middleware('auth:sanctum');


Route::post('/changeStatus', [orderController::class, 'changeOrderStatus'])->middleware('auth:sanctum');