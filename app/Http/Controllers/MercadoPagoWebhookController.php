<?php
namespace App\Http\Controllers;
use App\Http\Services\OrderService;
use Illuminate\Http\Request;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;

class MercadoPagoWebhookController
{
    public function __construct(private OrderService $orderService) {}

    public function handle(Request $request)
    {
        http_response_code(200);

        if ($request->input('type') !== 'payment') {
            return response()->json(['ignored' => true]);
        }

        $paymentId = $request->input('data.id');

        // Acess token
        MercadoPagoConfig::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));

        // Cliente do Mercado Pago
        $client = new PaymentClient();

        // Buscar o pagamento
        $payment = $client->get($paymentId);

        // ID do pedido no seu sistema
        $orderId = $payment->external_reference;

        // Agora trate o status
        switch ($payment->status) {
            case "approved":
                $this->orderService->changeOrderStatus('preparando');
                break;

            case "in_process":
                $this->orderService->changeOrderStatus('processando');
                break;

            case "rejected":
                $this->orderService->changeOrderStatus('cancelado');
                break;
        }

        return response()->json(['status' => 'ok']);
    }
}
