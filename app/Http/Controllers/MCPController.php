<?php

namespace App\Http\Controllers;

use ErrorException;
use MercadoPago\MercadoPagoConfig;
use Illuminate\Http\Request;
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\Preference\PreferenceClient;

MercadoPagoConfig::setAccessToken("TEST-8122201493644649-111921-79354c1ae0b4dcd67b23b6efddcd6966-764163220");

class MCPController extends Controller
{
    public function createPreference(Request $request)
    {
        try {
            $client = new PreferenceClient();
            $preference = $client->create([
                "items" => array(
                    array(
                        "title" => "Meu produto",
                        "quantity" => 1,
                        "unit_price" => 2000
                    )
                )
            ]);

            return response()->json([
                "id" => $preference->id,
                "url" => $preference->init_point,

            ]);
        } catch (ErrorException $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function proccessPayment(Request $request)
    {
        $data = $request->input("formData");

        if (!$data) {
            return response()->json(["error" => "formData ausente"], 400);
        }

        $client = new PaymentClient();
        $request_options = new RequestOptions();

        $payment = $client->create([
            "transaction_amount"   => (float) $data["transaction_amount"],
            "token"                => $data["token"],
            "description"          => "Pedido no meu site",
            "installments"         => $data["installments"],
            "payment_method_id"    => $data["payment_method_id"],
            "issuer_id"            => $data["issuer_id"],

            "payer" => [
                "email" => $data["payer"]["email"],
                "identification" => [
                    "type"   => $data["payer"]["identification"]["type"],
                    "number" => $data["payer"]["identification"]["number"]
                ]
            ]
        ], $request_options);

        return response()->json($payment);
    }

    public function proccessPaymentPix(Request $request)
    {

          $data = $request->all(); 
          
        $client = new PaymentClient();
        $request_options = new RequestOptions();
        $request_options->setCustomHeaders(["X-Idempotency-Key: <SOME_UNIQUE_VALUE>"]);

        $payment = $client->create([
            "transaction_amount" => (float) $data['transaction_amount'],
            "payment_method_id" => $data['payment_method_id'],
            "payer" => [
                "email" => $data['payer']['email'],
            ]
        ], $request_options);

        return response()->json($payment);
    }
}
