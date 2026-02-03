<?php

namespace App\Http\Services;

use App\Models\ImagesProduct;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ProductService
{

    public function createProduct(array $products): Product
    {
        $product = new Product;
        $product->name = $products['name'];
        $product->description = $products['description'];
        $product->price = $products['price'];
        $product->lastPrice = $products['lastPrice'] ?? null;
        $product->fkCategory = $products['idCategory'];
        $product->fkSubcategory = $products['idSubcategory'];
        $product->save();

        foreach ($products['images'] as $images) {
            $tableImages = new ImagesProduct();
            $tableImages->idProduct = $product->id;
            $tableImages->image = $images;
            $tableImages->save();
        }

        foreach ($products['colors'] as $color) {
            $tableColors = new ProductColor();
            $tableColors->fkProduct = $product->id;
            $tableColors->fkColor = $color;
            $tableColors->save();
        }

        foreach ($products['sizes'] as $size) {
            $tableSizes = new ProductSize();
            $tableSizes->fkProduct = $product->id;
            $tableSizes->fkSize = $size;
            $tableSizes->save();
        }
        return $product;
    }

    public function getProductByCategory($id): Collection
    {
        $products = Product::with(['category',])->where('fkCategory', $id)->get();

        $result = $products->map(function ($product) {
            return [
                "id" => $product->id,
                "name" => $product->name,
                "price" => $product->price,
                "lastPrice" => $product->lastPrice,
                'description' => $product->description,
                "category" => $product->category,
                'sizes' => $product->sizes->pluck('name'),
                'color' => $product->colors->pluck('name'),
                "image" => $product->images->pluck('image'),

            ];
        });


        return $result;
    }

    public function getProductById($id)
    {
        $product = Product::with(['category',])->where('id', $id)->first();

        if (!$product) {
            return response()->json(['error' => 'Produto não encontrado'], 404);
        }

        $result = [
            "id" => $product->id,
            "name" => $product->name,
            "price" => $product->price,
            "lastPrice" => $product->lastPrice,
            'category' => $product->category->id,

            'categoryName' => $product->category->name,
            'sizes' => $product->sizes->map(function ($size) {
                return [
                    'id' => $size->id,
                    'name' => $size->name
                ];
            }),
            'color' => $product->colors->map(function ($color) {
                return [
                    'id' => $color->id,
                    'name' => $color->name
                ];
            }),
            'description' => $product->description,
            "image" => $product->images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'image' => $image->image
                ];
            })

        ];

        return $result;
    }

    public function fethPricesProduct(array $products)
    {
        $priceItems = [];

        foreach ($products as $item) {
            $product = Product::find($item['id']);
            if ($product) {
                $totalItemPrice = $product->price * $item['quantity'];
                $priceItems[] = $totalItemPrice;
            }
        }
        $sumPrice = array_sum($priceItems);

        return $sumPrice;
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
                'idSubcategory' => $product->fkSubcategory,
            ];
        });


        return response()->json($result);
    }


    public function searchProduct($search)
    {
        $products = Product::where('name', 'like', '%' . $search . '%')
            ->with(['category', 'sizes', 'images', 'category.subCategories'])->get();

        $result = $products->map(function ($product) {
            return [
                "id" => $product->id,
                "name" => $product->name,
                "price" => $product->price,
                "lastPrice" => $product->lastPrice,
                'description' => $product->description,
                "category" => [
                    "id" => $product->category->id,
                    "name" => $product->category->name,

                ],
                "image" => $product->images->pluck('image'),
                "sizes" => $product->sizes->pluck('name'),
                "color" => $product->colors->pluck('name'),
                 'idSubcategory' => $product->fkSubcategory,

            ];
        });

        return response()->json($result);
    }
}