<?php

use App\Http\Controllers\SubCategory\listSubCategoryByIdcategory;
use Illuminate\Support\Facades\Route;

Route::prefix('subCategory')->group(function (){
  Route::get('/listSubCategories/{name}',listSubCategoryByIdcategory::class);
});