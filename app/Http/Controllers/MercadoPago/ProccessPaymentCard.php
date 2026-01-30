<?php

namespace App\Http\Controllers\MercadoPago;

use App\Http\Controllers\Controller;
use App\Http\Services\MCPService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

#[Group('MercadoPago')]
class ProccessPaymentCard extends Controller
{
    /**
     * Process payment card
     */

    public function __construct(private MCPService $mcpService)
    {
        $this->mcpService = $mcpService;
    }

    public function __invoke(Request $request)
    {
        $user = $request->user();

        if(!$user) {
            return response()->json(['Não autenticado'], Response::HTTP_UNAUTHORIZED);
        }


        return $this->mcpService->processPayment($request->formdata, $request->order,$user);
    }
}