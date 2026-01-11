<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Services\ProductService;
use Dedoc\Scramble\Attributes\Group;

#[Group('Product')]
class ListProductController extends Controller
{

    /**
     * List all products.
     */

    public function __construct(private ProductService $productService)
    {
        $this->productService = $productService;
    }


    public function __invoke()
    {
        return $this->productService->fetchProduct();
    }
}