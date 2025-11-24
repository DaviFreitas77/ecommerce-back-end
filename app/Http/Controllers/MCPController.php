<?php

namespace App\Http\Controllers;

use App\Http\services\OrderItemsService;
use App\Http\services\OrderService;
use App\Http\services\ProductService;
use App\Http\services\ShoppingCartService;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use ErrorException;
use MercadoPago\MercadoPagoConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\Preference\PreferenceClient;

MercadoPagoConfig::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));

class MCPController extends Controller
{
    public function __construct(private ProductService $productService, private OrderService $orderService, private OrderItemsService $orderItemsService, private ShoppingCartService $shoppingCartService) {}

    public function createPreference(Request $request)
    {
        $validated = $request->validate([
            'items' => ['required', 'array'],
        ]);

        $userId = Auth::user()->id;

        $sumPrice = $this->productService->fethPricesProduct($validated['items']);

        $existingOrder = Order::where('fk_user', $userId)->where('status', 'pending')->first();

        if ($existingOrder) {
            $orderItems = OrderItems::where('fk_order', $existingOrder->id);

            if ($orderItems) {
                $orderItems->delete();
            }


            $newOrderItems = $this->orderItemsService->create($validated['items'], $existingOrder->id);


            $existingOrder->total = $sumPrice;
            $existingOrder->save();
            $orderId = $existingOrder->id;
        } else {
            //cria um novo pedido
            $newOder = $this->orderService->create($userId, 'pending', $sumPrice);
            $orderId = $newOder->id;

            $newOrderItems = $this->orderItemsService->create($validated['items'], $newOder->id);
        }


        $mpItems = array_map(function ($item) {
            $product = Product::find($item['id']);
            if (!$product) {
                throw new \Exception("Produto não encontrado: ID {$item['id']}");
            }

            return [
                "title" => $item['name'],
                "quantity" => max(1, (int)$item['quantity']),
                "unit_price" => (float)$product->price,
            ];
        }, $validated['items']);

        try {
            $client = new PreferenceClient();
            $preference = $client->create([
                "items" => $mpItems,

            ]);

            return response()->json([
                "id" => $preference->id,
                "url" => $preference->init_point,
                "total" => $sumPrice,
                "order" => $orderId


            ]);
        } catch (ErrorException $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
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
                $this->orderService->changeOrderStatus('preparando');
                $this->orderService->updatePaymentOrderService($payment->payment_type_id, $payment->external_reference);
                $this->shoppingCartService->deleteCartUser(Auth::user()->id);
                
            }elseif($payment->status === "in_process"){
                $this->orderService->changeOrderStatus('processando');

            }
        
            else {
                return response()->json($payment);
            }
            return response()->json($payment);
        } catch (ErrorException $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
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
