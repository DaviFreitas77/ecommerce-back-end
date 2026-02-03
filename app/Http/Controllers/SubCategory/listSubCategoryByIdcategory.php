<?php

namespace App\Http\Controllers\SubCategory;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class listSubCategoryByIdcategory extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($idCategory)
    {

        $subCategories = SubCategory::where('id_category', $idCategory)->get();

        return response()->json(['subCategories' => $subCategories]);
    }
}