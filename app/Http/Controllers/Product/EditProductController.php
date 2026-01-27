<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class EditProductController extends Controller
{
    /**
     * Edit product
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['sometimes', 'string'],
            'description' => ['sometimes', 'string'],
            'price'       => ['sometimes', 'numeric'],
            'lastPrice'   => ['sometimes', 'numeric'],
            'productId'   => ['required', 'integer'],
        ]);




        $product = Product::find($validated['productId']);

        if (!$product) {
            return response()->json(['error' => 'Produto não encontrado'], Response::HTTP_NOT_FOUND);
        }

        $product->fill($validated);
        $product->save();

        return response()->json(['message' => 'Produto editado com sucesso'], Response::HTTP_OK);
    }
}