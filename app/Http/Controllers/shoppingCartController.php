<?php

namespace App\Http\Controllers;

use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class shoppingCartController extends Controller
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


    public function shoppingCart()
    {

        $idUser = Auth::user()->id;
        $shoppingCart = ShoppingCart::where('fkUser', $idUser)->first();

        if (!$shoppingCart) {
            return response()->json(['message' => "carrinnho não encontrado"], 400);
        }
        return response()->json($shoppingCart);
    }
}
