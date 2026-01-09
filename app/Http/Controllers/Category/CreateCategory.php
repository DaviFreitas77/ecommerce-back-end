<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Services\CategoryService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;


#[Group('category')]
class CreateCategory extends Controller
{
    /**
     * Cria Categoria.
     */

    public function __construct(private CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function __invoke(StoreCategoryRequest $request)
    {
        $data = $request->validated();

        return $this->categoryService->createCategory($data);
    }
}