<?php

namespace App\Http\Controllers\MercadoPago;

use App\Http\Controllers\Controller;
use ErrorException;
use Illuminate\Http\Request;
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Payment\PaymentClient;

class ProccessPaymentPix extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $data = $request->all();
            $client = new PaymentClient();
            $request_options = new RequestOptions();


            $payment = $client->create([
                "transaction_amount" => (float) $data['transaction_amount'],
                "payment_method_id" => $data['payment_method_id'],
                "payer" => [
                    "email" => $data['payer']['email'],
                ]
            ], $request_options);

            return response()->json($payment);
        } catch (ErrorException $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}