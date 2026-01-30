<?php

namespace App\Http\Controllers\Shopping;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shopping\StoreShoppingRequest;
use App\Http\Services\ShoppingCartService;
use App\Models\Product;
use App\Models\ProductShoppingCart;
use App\Models\ShoppingCart;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Support\Facades\Auth;


#[Group('Shopping Cart')]
class AddProductInCart extends Controller
{
    /**
     * Add product in shopping cart.
     */

    public function __construct(private ShoppingCartService $shoppingCartService)
    {
        $this->shoppingCartService = $shoppingCartService;
    }

    public function __invoke(StoreShoppingRequest $request)
    {

        $data = $request->validated();
        $idUser = $request->user()->id;

        //verifica se o carrinho ja existe e retorta id,se não,cria um e retorna o id 
        $cartId = $this->shoppingCartService->createShoppingCart($idUser);

        $shoppingCart = ShoppingCart::find($cartId);

        $priceProduct = Product::where('id', $data['idProduct'])->first()->price;

        //verifica se o produto existe no carrinho,se sim ,soma na quantidade
        $existingProduct = ProductShoppingCart::where('fkShoppingCart', $cartId)
            ->where('fkProduct', $data['idProduct'])
            ->where('fkSize', $data['idSize'])
            ->where('fkColor', $data['idColor'])
            ->first();


        if ($existingProduct) {
            $existingProduct->quantity += $data['quantity'];
            $existingProduct->save();
        } else {
            $product = new ProductShoppingCart();
            $product->fkShoppingCart = $cartId;
            $product->fkProduct = $data['idProduct'];
            $product->fkSize = $data['idSize'];
            $product->fkColor = $data['idColor'];
            $product->quantity = $data['quantity'];
            $product->save();
        }

        // Atualizar totalPrice corretamente
        $shoppingCart->totalPrice += $priceProduct * $data['quantity'];
        $shoppingCart->save();

        return response()->json(['message' => 'produto adicionado ao carrinho']);
    }
}