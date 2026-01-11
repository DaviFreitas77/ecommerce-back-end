<?php

use App\Http\Controllers\Logradouro\CheckZipCodeController;
use App\Http\Controllers\Logradouro\CreateLogradouroController;
use App\Http\Controllers\Logradouro\DeleteLogradouroController;
use App\Http\Controllers\Logradouro\LogradouroUserController;
use Illuminate\Support\Facades\Route;

Route::prefix('logradouro')->group(function(){
  Route::post('/create',CreateLogradouroController::class);
  Route::delete('/deleteLogradouro/{id}',DeleteLogradouroController::class);
  Route::get('logradouroByUser',LogradouroUserController::class);
    Route::post('/checkZipCode', CheckZipCodeController::class);
});