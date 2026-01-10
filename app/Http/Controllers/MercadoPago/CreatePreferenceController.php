<?php

namespace App\Http\Controllers\MercadoPago;

use App\Http\Controllers\Controller;
use App\Http\Services\MCPService;
use Illuminate\Http\Request;
use MercadoPago\MercadoPagoConfig;

MercadoPagoConfig::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));
class CreatePreferenceController extends Controller
{
    /**
     * Handle the incoming request.
     */

    public function __construct(private MCPService $mcpService)
    {
        $this->mcpService = $$mcpService;
    }

    public function __invoke($items, $sumPrice, $orderId)
    {
        $newPreference = $this->mcpService->createPreferenceService($items, $sumPrice, $orderId);
        return $newPreference;
    }
}