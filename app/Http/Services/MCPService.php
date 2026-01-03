<?php

namespace App\Http\Services;

use App\Models\Product;
use MercadoPago\Client\Preference\PreferenceClient;
use ErrorException;
use MercadoPago\MercadoPagoConfig;

MercadoPagoConfig::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));

class MCPService
{
    public function createPreferenceService($items, $sumPrice, $orderId)
    {


        $mpItems = array_map(function ($items) {
            $product = Product::find($items['id']);
            if (!$product) {
                throw new \Exception("Produto não encontrado: ID {$items['id']}");
            }
            return [
                "title" => $items['name'],
                "quantity" => max(1, (int)$items['quantity']),
                "unit_price" => (float)$product->price,
            ];
        }, $items);

        try {
            $client = new PreferenceClient();
            $preference = $client->create([
                "items" => $mpItems,

            ]);

            return [
                "id" => $preference->id,
                "url" => $preference->init_point,
                "total" => $sumPrice,
                "orderId" => $orderId
            ];
        } catch (ErrorException $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
