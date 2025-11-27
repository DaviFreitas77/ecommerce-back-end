<?php

namespace App\Http\Services;
use App\Models\ShoppingCart;


class ShoppingCartService
{


  
    public function deleteCartUser($idUser)
    {
         $shoppingCart = ShoppingCart::where('fkUser', $idUser)->first();

        $shoppingCart->delete();

        return response()->json(['message' => 'carrinho deletado']);
    }
}
