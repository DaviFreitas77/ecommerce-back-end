<?php

namespace App\Http\Controllers;

use App\Http\Services\ColorService;
use App\Http\Services\MCPService;
use App\Http\Services\OrderService;
use App\Http\Services\ProductService;
use App\Http\Services\ShoppingCartService;
use App\Http\Services\SizeService;
use App\Mail\mailOrderCreated;
use App\Models\Order;
use App\Models\OrderItems;
use ErrorException;
use MercadoPago\MercadoPagoConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MercadoPago\Exceptions\MPApiException;

use Illuminate\Support\Facades\Mail;
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Payment\PaymentClient;


MercadoPagoConfig::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));

class MCPController extends Controller
{
    public function __construct(private MCPService $mcpService) {}

    public function createPreference($items, $sumPrice, $orderId)
    {
        $newPreference = $this->mcpService->createPreferenceService($items, $sumPrice, $orderId);
        return $newPreference;
    }
    public function proccessPayment(Request $request)
    {

        return $this->mcpService->processPayment($request->formdata, $request->order);
    }

    public function proccessPaymentPix(Request $request)
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