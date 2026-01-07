<?php

namespace App\Http\Controllers;

use App\Http\Services\CategoryService;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller

{


    public function __construct(private CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function createCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string']
        ], [
            'name.required' => 'O nome da categoria é obrigatório.',
        ]);

        return $this->categoryService->createCategory($validated);
    }

    public function fetchCategory()
    {
        return $this->categoryService->listAllCategories();
    }
}