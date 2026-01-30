<?php

namespace App\Http\Controllers\Shopping;

use App\Http\Controllers\Controller;
use App\Models\ProductShoppingCart;
use App\Models\ShoppingCart;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

#[Group('Shopping Cart')]
class GetCartController extends Controller
{
    /**
     * Get cart.
     */
    public function __invoke(Request $request)
    {
        $idUser = $request->user()->id;

        $shoppingCart = ShoppingCart::where('fkUser', $idUser)->first();
        if (!$shoppingCart) {

            if (!$shoppingCart) {
                $shoppingCart = ShoppingCart::create([
                    'fkUser' => $idUser,
                    'totalPrice' => 0,
                ]);

                return response()->json([
                    'productsCart' => [],
                ], Response::HTTP_OK);
            }
        }

        $idShoppingCart = $shoppingCart->id;

        $productsCart = ProductShoppingCart::where('fkShoppingCart', $idShoppingCart)
            ->join('products', 'product_shopping_cart.fkProduct', '=', 'products.id')
            ->join('product_colors', 'product_shopping_cart.fkColor', '=', 'product_colors.id')
            ->join('colors', 'product_colors.fkColor', '=', 'colors.id')
            ->join('product_sizes', 'product_shopping_cart.fkSize', '=', 'product_sizes.id')
            ->join('sizes', 'product_sizes.fkSize', '=', 'sizes.id')
            ->join('images_products', function ($join) {
                $join->on('products.id', '=', 'images_products.idProduct')
                    ->where('images_products.id', function ($query) {
                        $query->select('id')
                            ->from('images_products as ip')
                            ->whereColumn('ip.idProduct', 'products.id')
                            ->orderBy('ip.id')
                            ->limit(1);
                    });
            })
            ->select(
                'product_shopping_cart.quantity',
                'products.id as id',
                'products.name as name',
                'products.price',
                'colors.name as colorName',
                'colors.id as color',
                'sizes.id as size',
                'sizes.name as sizeName',
                'images_products.image'
            )
            ->get();

        return response()->json(["productsCart" => $productsCart], Response::HTTP_OK);
    }
}