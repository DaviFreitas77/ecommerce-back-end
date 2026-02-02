<?php

namespace App\Http\Controllers\Filter;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SubCategory;


class filterSubCategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($nameSubCategory)
    {
        $idSubCategory = SubCategory::where('name', $nameSubCategory)->first()->id;
        
        $productsBySubCategory = Product::where('fkSubcategory', $idSubCategory)->get();

        $result  = $productsBySubCategory->map(function($product){
            return[
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'lastPrice' => $product->lastPrice,
                'description' => $product->description,
                'category' => $product->category,
                'image' => $product->images->pluck('image'),
                'sizes' => $product->sizes->pluck('name'),
                'color' => $product->colors->pluck('name'), 
                'idSubcategory' => $product->fkSubcategory,
            ];
        });
    
        return response()->json($result);
        
    }
}