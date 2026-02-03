<?php

namespace App\Http\Controllers\SubCategory;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;


class listSubCategoryByNamecategory extends Controller
{
    /**
     * get sub category by id category
     */
    public function __invoke($nameCategory)
    {

        $idCategory = Category::where('name', $nameCategory)->first()->id;
    
        $subCategories = SubCategory::where('id_category', $idCategory)->get();
        $category = Category::find($idCategory);
        
        $products = Product::all();
        $result = [];
        
        foreach($products as $products){
            $cotainsSubCategory =  $products->fkSubcategory;
            foreach($subCategories as $subCategory){
                if($subCategory->id === $cotainsSubCategory && $subCategory->id_category === $category->id){
                    if(!in_array($subCategory, $result)){
                        $result[] = $subCategory;
                        
                    }
                }
            }
        }
            
        
        
    
        return response()->json(['subCategories' => $result]);
    }
    
    
}