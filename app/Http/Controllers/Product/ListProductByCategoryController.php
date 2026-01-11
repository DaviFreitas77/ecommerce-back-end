<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Services\ProductService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Response;


#[Group('Product')]
class ListProductByCategoryController extends Controller
{
    /**
     * List product by category
     */
    public function __construct(private ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function __invoke($id)
    {
        $products = $this->productService->getProductByCategory($id);

        if ($products->isEmpty()) {
            return response()->json(['message' => "Nenhum Produto Encontrado"],Response::HTTP_NOT_FOUND);
        }
        return response()->json($products,Response::HTTP_OK);
    }
}