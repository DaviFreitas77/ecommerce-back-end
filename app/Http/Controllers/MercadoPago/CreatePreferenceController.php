<?php

namespace App\Http\Controllers\MercadoPago;

use App\Http\Controllers\Controller;
use App\Http\Services\MCPService;
use Dedoc\Scramble\Attributes\Group;
use MercadoPago\MercadoPagoConfig;

MercadoPagoConfig::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));

#[Group('MercadoPago')]
class CreatePreferenceController extends Controller
{
    /**
     * Create preference Mercado pago.
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