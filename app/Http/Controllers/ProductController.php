<?php

namespace App\Http\Controllers;

use App\Http\Services\ProductService;
use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{

    public function __construct(private ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function createProduct(Request $request)
    {

        // if ($request->user()->role !== 'adm') {
        //     return response()->json(['error' => 'Acesso não autorizado'], 403);
        // }

        $validated = $request->validate([
            'name' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'description' => ['required', 'string'],
            'idCategory' => ['required', 'integer'],
            'lastPrice' => ['nullable', 'numeric'],
            'images' => ['required', 'array'],
            'colors' => ['required', 'array'],
            'sizes' => ['required', 'array'],

        ]);

        $product = $this->productService->createProduct($validated);

        return response()->json(['message' => "Produto cadastrado", $product], 201);
    }

    public function fetchProduct()
    {
        return $this->productService->fetchProduct();
    }


    public function getProductByCategory($id)
    {
        $products = $this->productService->getProductByCategory($id);

        if ($products->isEmpty()) {
            return response()->json(['message' => "Nenhum Produto Encontrado"]);
        }
        return response()->json($products);
    }

    public function fetchProductId($id)
    {
        $product = $this->productService->getProductById($id);
        return response()->json($product);
    }


    public function recomendation($id)
    {
        return $this->productService->recomendation($id);
    }

    public function delProduct($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => "produto não existe"]);
        }

        $product->delete();

        return response()->json(['message' => "produto deletado"]);
    }

    public function searchProduct($search)
    {
        return $this->productService->searchProduct($search);
    }
}