<?php

namespace App\Http\Controllers;

use App\Http\services\ProductService;
use App\Models\imagesProduct;
use App\Models\ImagesProduct as ModelsImagesProduct;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductVariacoes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{

    public function __construct(private ProductService $productService) {}
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
        $products = Product::with(['category'])->get();

        $result = $products->map(function ($product) {
            return [
                "id" => $product->id,
                "name" => $product->name,
                "price" => $product->price,
                "lastPrice" => $product->lastPrice,
                'description' => $product->description,
                "category" => $product->category,
                "image" => $product->images->pluck('image'),
                'sizes' => $product->sizes->pluck('name'),
                'color' => $product->colors->pluck('name'),
            ];
        });


        return response()->json($result);
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
        $product = Product::with(['variations'])->where('id', '=', $id)->first();

        $category = $product->category->id;

        $products = Product::with('variations')->where('fkCategory', $category)->where("id", "!=", $id)->limit(6)->get();

        if ($products->isEmpty()) {
            $allProduct = Product::with("variations")->limit(6)->get();
            $result = $allProduct->map(function ($prod) {
                return  [
                    'id' => $prod->id,
                    "name" => $prod->name,
                    "price" => $prod->price,
                    "lastPrice" => $prod->lastPrice,
                    "image" => $prod->variations->first()->image,
                    'category' => $prod->category,

                ];
            });
            return response()->json($result);
        }
        $result = $products->map(function ($prod) {
            return  [
                'id' => $prod->id,
                "name" => $prod->name,
                "price" => $prod->price,
                "lastPrice" => $prod->lastPrice,
                "image" => $prod->variations->first()->image,
                'category' => $prod->category,

            ];
        });

        return response()->json($result);
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
        $products = Product::where('name', 'like', '%' . $search . '%')
            ->orWhereHas('category', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->with(['category', 'sizes', 'images'])->get();

        $result = $products->map(function ($product) {
            return [
                "id" => $product->id,
                "name" => $product->name,
                "price" => $product->price,
                "lastPrice" => $product->lastPrice,
                'description' => $product->description,
                "category" => $product->category,
                "image" => $product->images->pluck('image'),
                "sizes" => $product->sizes->pluck('name'),
                "color" => $product->colors->pluck('name'),
            ];
        });

        return response()->json($result);
    }
}
