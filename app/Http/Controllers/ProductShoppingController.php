<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductShoppingCart;
use App\Models\ShoppingCart;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductShoppingController extends Controller
{
    public function addCart(Request $request)
    {
        $validated = $request->validate([
            'idProduct' => ['required', 'integer'],
            'idSize' => ['required', 'integer'],
            'idColor' => ['required', 'integer'],
            'quantity' => ['required', 'integer'],

        ]);
        $idUser = Auth::user()->id;

        //verifica se o carrinho ja existe,se não,cria um e retorna o id
        $shoppingCtrl = new ShoppingCartController();
        $cartId = $shoppingCtrl->createShoppingCart($idUser);

        $shoppingCart = ShoppingCart::find($cartId);


        $priceProduct = Product::where('id', $validated['idProduct'])->first()->price;



        //verifica se o produto existe no carrinho,se sim ,soma na quantidade
        $existingProduct = ProductShoppingCart::where('fkShoppingCart', $cartId)
            ->where('fkProduct', $validated['idProduct'])
            ->where('fkSize', $validated['idSize'])
            ->where('fkColor', $validated['idColor'])
            ->first();


        if ($existingProduct) {
            $existingProduct->quantity += $validated['quantity'];
            $existingProduct->save();
        } else {
            $product = new ProductShoppingCart();
            $product->fkShoppingCart = $cartId;
            $product->fkProduct = $validated['idProduct'];
            $product->fkSize = $validated['idSize'];
            $product->fkColor = $validated['idColor'];
            $product->quantity = $validated['quantity'];
            $product->save();
        }



        // Atualizar totalPrice corretamente
        $shoppingCart->totalPrice += $priceProduct * $validated['quantity'];
        $shoppingCart->save();

        return response()->json(['message' => 'produto adicionado ao carrinho']);
    }


    public function syncCart(Request $request)
    {
        $validated = $request->validate([
            'products' => ['array'],

        ]);

        if (empty($validated['products'])) {
            return;
        }
        $idUser = Auth::user()->id;
        $shoppingCart = ShoppingCart::where('fkUser', $idUser)->first();

        if (!$shoppingCart) {
            $shoppingCart = ShoppingCart::create([
                'fkUser' => $idUser,
                'totalPrice' => 0,
            ]);
        }

        // Apaga os itens antigos
        ProductShoppingCart::where('fkShoppingCart', $shoppingCart->id)->delete();

        // Prepara os novos itens (sem salvar ainda)
        $productsToInsert = [];
        foreach ($validated['products'] as $product) {
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
        ], 200);
    }


    public function getCart(Request $request)
    {
        $idUser = Auth::user()->id;

        $shoppingCart = ShoppingCart::where('fkUser', $idUser)->first();
        if (!$shoppingCart) {
            return response()->json([], 200);
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

        return response()->json($productsCart);
    }
}
