<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Response;

#[Group('Product')]
class DeleteProductController extends Controller
{
    /**
     * Delete Product
     */
    public function __invoke($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => "produto não existe"],Response::HTTP_NOT_FOUND);
        }

        $product->delete();

        return response()->json(['message' => "produto deletado"],Response::HTTP_OK);
    }
}