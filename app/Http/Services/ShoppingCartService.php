<?php

namespace App\Http\Services;

use App\Models\ShoppingCart;


class ShoppingCartService
{

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

    public function deleteCartUser($idUser)
    {
        $shoppingCart = ShoppingCart::where('fkUser', $idUser)->first();

        $shoppingCart->delete();

        return response()->json(['message' => 'carrinho deletado']);
    }
}