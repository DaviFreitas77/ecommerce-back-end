<?php

namespace App\Http\Controllers\Shopping;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shopping\SyncCartRequest;
use App\Models\ProductShoppingCart;
use App\Models\ShoppingCart;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

#[Group('Shopping Cart')]
class SyncCartController extends Controller
{
    /**
     * synchronize shopping cart
     */
    public function __invoke(SyncCartRequest $request)
    {
        $data = $request->validated();



        if (empty($data['products'])) {
            return response()->json([
                'message' => 'Carrinho sincronizado!',
                'total' => 0
            ]);
        }
        $idUser = $request->user()->id;
        $shoppingCart = ShoppingCart::where('fkUser', $idUser)->first();

        // Apaga os itens antigos
        ProductShoppingCart::where('fkShoppingCart', $shoppingCart->id)->delete();

        // Prepara os novos itens (sem salvar ainda)
        $productsToInsert = [];
        foreach ($data['products'] as $product) {
            $productsToInsert[] = [
                'fkShoppingCart' => $shoppingCart->id,
                'fkProduct' => $product['id'],
                'fkSize' => $product['size'],
                'fkColor' => $product['color'],
                'quantity' => $product['quantity'],
            ];
        }

        // Insere todos os novos itens de UMA VEZ
        if (!empty($productsToInsert)) {
            ProductShoppingCart::insert($productsToInsert);
        }

        // CALCULA O TOTAL 
        $totalPrice = ProductShoppingCart::where('fkShoppingCart', $shoppingCart->id)
            ->join('products', 'product_shopping_cart.fkProduct', '=', 'products.id')
            ->sum(DB::raw('products.price * product_shopping_cart.quantity'));

        //ATUALIZA o carrinho principal com o novo total
        $shoppingCart->totalPrice = $totalPrice;
        $shoppingCart->save();

        return response()->json([
            'message' => 'Carrinho sincronizado!',
            'total' => $totalPrice
        ], Response::HTTP_OK);
    }
}