<?php

namespace App\Http\Services;
use App\Models\OrderItems;
use App\Models\Product;


class OrderItemsService
{


    public function create(array $products, int $idOrder)
    {

        foreach ($products as $item) {
            $product = Product::find($item['id']);
            if ($product) {
                $newOrderItems = OrderItems::create([
                    'fk_product' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'total' => $product->price * $item['quantity'],
                    'fk_color'=> $item['color'],
                    'fk_size'=> $item['size'],
                    'fk_order' => $idOrder,

                ]);
                $newOrderItems->save();
            }

        }
    }
}
