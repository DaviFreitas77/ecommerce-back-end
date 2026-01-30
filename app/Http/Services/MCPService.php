<?php

namespace App\Http\Services;

use App\Jobs\SendNewOrderEmailToAdminJob;
use App\Jobs\SendOrderCreatedEmailJob;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use App\Models\User;
use MercadoPago\Client\Preference\PreferenceClient;
use ErrorException;

use Illuminate\Support\Facades\Auth;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\MPApiException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

MercadoPagoConfig::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));

class MCPService
{

    public function __construct(private ColorService $colorService, private SizeService $sizeService, private OrderService $orderService, private ShoppingCartService $shoppingCartService)
    {
        $this->colorService = $colorService;
        $this->sizeService = $sizeService;
        $this->orderService = $orderService;
        $this->shoppingCartService = $shoppingCartService;
    }

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
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function processPayment($formdata, $order,  User $user)
    {
        $nameUser  = $user['name'];
        $emailUser = $user['email'];
        $telUser   = $user['tel'];
        $userId    = $user['id'];


        try {
            $data = $formdata;
            $order = $order;


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
                "issuer_id" => (int) $data["issuer_id"],


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

            //numero do pedido
            $numberOrder = Order::where('id', $payment->external_reference)->first();

            //recuperando produtos ligado ao pedido
            $orderItems = OrderItems::with('product.images')->where('fk_order', $numberOrder->id)->get();

            $productsData = $orderItems->map(function ($item) {
                $firstImage = $item->product->images->first();
                $imageUrl = $firstImage ? $firstImage->image : null;
                $colorName = $this->colorService->getColorById($item->fk_color);
                $sizeName = $this->sizeService->getSizeById($item->fk_size);
                return [
                    'name' => $item->product->name,
                    'price' => $item->product->price,
                    'color' => $colorName,
                    'size' => $sizeName,
                    'quantity' => $item->quantity,
                    'image' => $imageUrl
                ];
            })->toArray();

            if ($payment->status === "approved") {
                SendOrderCreatedEmailJob::dispatch($emailUser, $nameUser, $numberOrder->number_order, $productsData);

                SendNewOrderEmailToAdminJob::dispatch($nameUser, $numberOrder->number_order, $productsData, $telUser);

                $this->orderService->changeOrderStatus('preparando', $payment->external_reference);

                $this->orderService->updatePaymentOrderService($payment->payment_type_id, $payment->external_reference,$userId);

                $this->shoppingCartService->deleteCartUser($userId);
            } elseif ($payment->status === "in_process") {
                $this->orderService->changeOrderStatus('processando', $payment->external_reference);
            } else {
                return response()->json($payment);
            }
            return response()->json([
                'payment' => $payment,
                'numberOrder' => $numberOrder->number_order
            ], Response::HTTP_OK);
        } catch (MPApiException $e) {
            return response()->json([
                'status' => $e->getApiResponse()->getStatusCode(),
                'error'  => $e->getApiResponse()->getContent(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}