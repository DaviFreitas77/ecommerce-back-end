<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Services\ProductService;
use Dedoc\Scramble\Attributes\Group;

#[Group('Product')]
class SearchProductController extends Controller
{
    /**
     * Search product by query.
     */
    
    public function __construct(private ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function __invoke($search)
    {
        return $this->productService->searchProduct($search);
    }
}