<?php

namespace App\Http\Controllers\MercadoPago;

use App\Http\Controllers\Controller;
use Dedoc\Scramble\Attributes\Group;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Payment\PaymentClient;


#[Group('MercadoPago')]
class ProccessPaymentPix extends Controller
{
    /**
     * Process payment PIX
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

            return response()->json($payment, Response::HTTP_OK);
        } catch (ErrorException $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}