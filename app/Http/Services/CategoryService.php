<?php

namespace App\Http\Services;

use App\Models\Category;
use App\Models\Colors;

class CategoryService
{

  public function createCategory(array $data)
  {

    $existingCategpry = Category::where('name', $data['name'])->first();

    if ($existingCategpry) {
      return response()->json(['message' => "Categoria ja cadastrada"], 400);
    }

    $category = new Category;
    $category->name = $data['name'];
    $category->save();

    return response()->json(['message' => "categoria cadastrada"], 201);
  }


  public function listAllCategories()
  {
    return Category::all();
  }
}
