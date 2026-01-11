<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Services\ProductService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Response;

#[Group('Product')]
class ListProductByIdController extends Controller
{
    /**
     * List one product by ID.
     */
    public function __construct(private ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function __invoke($id)
    {
        $product = $this->productService->getProductById($id);
        return response()->json($product, Response::HTTP_OK);
    }
}