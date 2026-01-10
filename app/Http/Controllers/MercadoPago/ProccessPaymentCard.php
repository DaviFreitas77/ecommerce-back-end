<?php

namespace App\Http\Controllers\MercadoPago;

use App\Http\Controllers\Controller;
use App\Http\Services\MCPService;
use Illuminate\Http\Request;

class ProccessPaymentCard extends Controller
{
    /**
     * Handle the incoming request.
     */

    public function __construct(private MCPService $mcpService)
    {
        $this->mcpService = $mcpService;
    }

    public function __invoke(Request $request)
    {
        return $this->mcpService->processPayment($request->formdata, $request->order);
    }
}