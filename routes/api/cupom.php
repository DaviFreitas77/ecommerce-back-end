<?php
use App\Http\Controllers\Cupom\CreateCupomController;
use App\Http\Controllers\Cupom\DeleteCupomController;
use App\Http\Controllers\Cupom\ListCupomController;
use App\Http\Controllers\Cupom\UseCupomController;
use Illuminate\Support\Facades\Route;

Route::prefix('cupom')->group(function(){
  Route::post('/create',CreateCupomController::class);
  Route::get('/list',ListCupomController::class);
  Route::post('/useCupom',UseCupomController::class);
  Route::delete('/deleteCupom/{id}',DeleteCupomController::class);
});