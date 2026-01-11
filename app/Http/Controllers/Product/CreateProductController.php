<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Services\ProductService;
use Dedoc\Scramble\Attributes\Group;
use Symfony\Component\HttpFoundation\Response;


#[Group('Product')]
class CreateProductController extends Controller
{
    /**
     * Create Product
     */
    public function __construct(private ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function __invoke(StoreProductRequest $request)
    {

        // if ($request->user()->role !== 'adm') {
        //     return response()->json(['error' => 'Acesso não autorizado'], 403);
        // }


        $data = $request->validated();

        return $this->productService->createProduct($data);

        return response()->json(['message' => "Produto cadastrado", $product], Response::HTTP_CREATED);
    }
}