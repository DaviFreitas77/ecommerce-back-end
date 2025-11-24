<?php

namespace App\Http\services;

use App\Models\Order;
use App\Models\ShoppingCart;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ShoppingCartService
{
    public function construct() {}

  
    public function deleteCartUser($idUser)
    {
         $shoppingCart = ShoppingCart::where('fkUser', $idUser)->first();

        $shoppingCart->delete();

        return response()->json(['message' => 'carrinho deletado']);
    }
}
