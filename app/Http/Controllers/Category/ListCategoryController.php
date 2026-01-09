<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Services\CategoryService;
use Dedoc\Scramble\Attributes\Group;

#[Group('category')]
class ListCategoryController extends Controller
{
    /**
     * Listar todas as categorias.
     */
    public function __construct(private CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    public function __invoke()
    {
        return $this->categoryService->listAllCategories();
    }
}