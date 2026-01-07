<?php

namespace App\Http\Controllers;

use App\Http\Services\CupomService;
use App\Http\Services\MCPService;
use App\Http\Services\OrderService;
use App\Models\CupomUser;
use App\Models\DiscountCupom;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CupomController extends Controller
{
    public function __construct(private OrderService $orderService, private MCPService $mcpService, private CupomService $cupomService)
    {
        $this->orderService = $orderService;
        $this->mcpService = $mcpService;
        $this->cupomService = $cupomService;
    }

    public function createCupom(Request $request)
    {
        $validated = $request->validate([
            'nameCupom' => 'required|string|max:255',
            'discount' => 'required|numeric|min:0',
            'validity' => 'required|date',
            'limitUse' => 'required|integer|min:1',
        ]);

        return $this->cupomService->createCupom($validated);
    }

    public function listCupons()
    {

        return $this->cupomService->listAllCupom();
    }


    public function deleteCupom($id)
    {


        return $this->cupomService->deleteCupom($id);
    }

    public function useCupom(Request $request)
    {
        $validated = $request->validate([
            'nameCupom' => 'required|string|exists:discount_cupoms,nameCupom',
            'order' => 'required|integer|exists:tb_order,id',
        ], [
            'nameCupom.exists' => 'Cupom inválido.',
        ]);

        return $this->cupomService->useCupom($validated);
    }
}