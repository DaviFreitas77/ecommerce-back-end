<?php

namespace App\Http\Controllers\SubCategory;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;


class listSubCategoryByIdcategory extends Controller
{
    /**
     * get sub category by id category
     */
    public function __invoke($idCategory)
    {
        $subCategories = SubCategory::where('id_category', $idCategory)->get();

        return response()->json(['subCategories' => $subCategories]);
    }
    
}