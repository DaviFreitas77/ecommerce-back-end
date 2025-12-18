<?php

namespace App\Http\Controllers;

use App\Http\Services\MCPService;
use App\Http\Services\OrderService;
use App\Http\Services\ShoppingCartService;
use App\Mail\mailOrderCreated;
use ErrorException;
use MercadoPago\MercadoPagoConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Payment\PaymentClient;


MercadoPagoConfig::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));

class MCPController extends Controller
{
    public function __construct(private OrderService $orderService, private ShoppingCartService $shoppingCartService, private MCPService $mcpService) {}

    public function createPreference($items, $sumPrice, $orderId)
    {
        $newPreference = $this->mcpService->createPreferenceService($items, $sumPrice, $orderId);
        return $newPreference;
    }
    public function proccessPayment(Request $request)
    {
        try {
            $data = $request->formdata;
            $order = $request->order;


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
                ],
                "external_reference" => strval($order),
                // "notification_url" => "http://localhost:5173/api/webhook"


            ], $request_options);

            if ($payment->status === "approved") {
                  Mail::to('davifreitaz999@gmail.com')->send(new mailOrderCreated());
                $this->orderService->changeOrderStatus('preparando',$payment->external_reference);
                $this->orderService->updatePaymentOrderService($payment->payment_type_id, $payment->external_reference);
                $this->shoppingCartService->deleteCartUser(Auth::user()->id);
            } elseif ($payment->status === "in_process") {
                $this->orderService->changeOrderStatus('processando',$payment->external_reference);
            } else {
                return response()->json($payment);
            }
            return response()->json($payment);
        } catch (ErrorException $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
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
