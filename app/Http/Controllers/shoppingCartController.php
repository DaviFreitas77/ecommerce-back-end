<?php

namespace App\Http\Controllers;

use App\Http\Services\ShoppingCartService;
use App\Models\ProductShoppingCart;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class shoppingCartController extends Controller
{

     public function __construct(private ShoppingCartService $shoppingCartService) {
    }

    public function createShoppingCart($iduser)
    {
        $existingCart = ShoppingCart::where('fkUser', $iduser)->first();

        if (!$existingCart) {
            $shoppingCart = new ShoppingCart;
            $shoppingCart->fkUser = $iduser;
            $shoppingCart->totalPrice = 0;
            $shoppingCart->save();
            return $shoppingCart->id;
        }

        return $existingCart->id;
    }


    public function shoppingCart()
    {

        $idUser = Auth::user()->id;
        $shoppingCart = ShoppingCart::where('fkUser', $idUser)->first();
        $productsCart = ProductShoppingCart::where('fkShoppingCart', $shoppingCart->id)
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


        if (!$shoppingCart) {
            return response()->json(['message' => "carrinnho não encontrado"], 400);
        }
        return response()->json([
            'total' => $shoppingCart->totalPrice,
            'products' => $productsCart

        ]);
    }

    public function deleteShoppingCart($idUser)
    {
        $this->shoppingCartService->deleteCartUser($idUser);
        return response()->json(['message' => 'carrinho deletado']);
    }

}