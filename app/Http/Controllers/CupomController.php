<?php

namespace App\Http\Controllers;

use App\Http\Services\MCPService;
use App\Http\Services\OrderService;
use App\Models\CupomUser;
use App\Models\DiscountCupom;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CupomController extends Controller
{
    public function __construct(private OrderService $orderService, private MCPService $mcpService)
    {
        $this->orderService = $orderService;
    }

    public function createCupom(Request $request)
    {
        $validated = $request->validate([
            'nameCupom' => 'required|string|max:255',
            'discount' => 'required|numeric|min:0',
            'validity' => 'required|date',
            'limitUse' => 'required|integer|min:1',
        ]);

        // Lógica para criar um cupom de desconto
        $newCupom = new DiscountCupom;
        $newCupom->nameCupom = $validated['nameCupom'];
        $newCupom->discount = $validated['discount'];
        $newCupom->validity = $validated['validity'];
        $newCupom->limitUse = $validated['limitUse'];
        $newCupom->save();

        return response()->json(['message' => 'Cupom criado com sucesso']);
    }

    public function listCupons()
    {
        $cupons = DiscountCupom::all();
        return response()->json($cupons);
    }


    public function deleteCupom($id)
    {
        $cupom = DiscountCupom::find($id);
        if (!$cupom) {
            return response()->json(['message' => 'Cupom não encontrado'], 404);
        }

        $cupom->delete();
        return response()->json(['message' => 'Cupom deletado com sucesso']);
    }

    public function useCupom(Request $request)
    {
        $validated = $request->validate([
            'nameCupom' => 'required|string|exists:discount_cupoms,nameCupom',
            'order' => 'required|integer|exists:tb_order,id',
        ],[
            'nameCupom.exists' => 'Cupom inválido.',
        ]);


        $idUser = Auth::user()->id;
        $userCupom = new CupomUser;
        $cupom = DiscountCupom::where("nameCupom", $validated['nameCupom'])->first();
        if (!$cupom) {
            return response()->json(['message' => 'Cupom não encontrado'], 404);
        }

        if ($cupom->limitUse <= 0) {
            return response()->json(['message' => 'Cupom esgotado'], 400);
        }

        if ($cupom->nameCupom === '1COMPRA') {
            $usedCupom =  $userCupom->where('fk_user', $idUser)
                ->where('fk_cupom', $cupom->id)
                ->exists();
            if ($usedCupom) {
                return response()->json(['message' => 'Você ja ultizou este cupom!'], 400);
            }
        }


        $order = $this->orderService->orderById($validated['order']);
        if (!$order) {
            return response()->json(['message' => 'Pedido não encontrado'], 404);
        }
        $orderItems =  OrderItems::where('fk_order', $order->id)->get();

        $calcDiscount = $order->total / 100 * $cupom->discount;
        $total = round($order->total - $calcDiscount,2);
        $order->total = $total;
        $order->fk_cupom = $cupom->id;
        $order->save();


        $cupom->limitUse--;
        $cupom->save();

        $userCupom->fk_user = $idUser;
        $userCupom->fk_cupom = $cupom->id;
        $userCupom->fk_order = $validated['order'];
        $userCupom->value = $cupom->discount;
        $userCupom->save();




        $mpItems = $orderItems->map(function ($item) {
            return [
                'id' => $item->product->id,
                'name' => $item->product->name,
                'quantity' => (int)$item->quantity,
                'unit_price' => (float)$item->price,
            ];
        })->toArray();


        $preference = $this->mcpService->createPreferenceService(
            $mpItems,      
            $total,        
            $order->id     
        );


        return response()->json(['message' => 'Cupom usado com sucesso', 'nameCupom' => $cupom->nameCupom, 'discount' => $cupom->discount, 'preference' => $preference], 200);
    }
}
