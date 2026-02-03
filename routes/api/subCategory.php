<?php

use App\Http\Controllers\SubCategory\listSubCategoryByIdcategory;
use App\Http\Controllers\SubCategory\listSubCategoryByNamecategory;
use Illuminate\Support\Facades\Route;

Route::prefix('subCategory')->group(function (){
  Route::get('/listSubCategories/{name}',listSubCategoryByNamecategory::class);
  Route::get('/listSubCategoriesByIdCategory/{id}',listSubCategoryByIdcategory::class);
});