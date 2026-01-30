<?php

namespace App\Http\Services;

use App\Models\CupomUser;
use App\Models\DiscountCupom;
use App\Models\OrderItems;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CupomService
{
    public function __construct(private OrderService $orderService, private MCPService $mcpService)
    {
        $this->orderService = $orderService;
        $this->mcpService = $mcpService;
    }

    public function createCupom(array $data)
    {
        $newCupom = new DiscountCupom;
        $newCupom->nameCupom = $data['nameCupom'];
        $newCupom->discount = $data['discount'];
        $newCupom->validity = $data['validity'];
        $newCupom->limitUse = $data['limitUse'];
        $newCupom->save();

        return response()->json(['message' => 'Cupom criado com sucesso'],Response::HTTP_CREATED);
    }


    public function listAllCupom()
    {
        $cupons = DiscountCupom::all();
        return response()->json($cupons,Response::HTTP_OK);
    }


    public function deleteCupom($id)
    {
        $cupom = DiscountCupom::find($id);
        if (!$cupom) {
            return response()->json(['message' => 'Cupom não encontrado'], Response::HTTP_NOT_FOUND);
        }

        $cupom->delete();
        return response()->json(['message' => 'Cupom deletado com sucesso'],Response::HTTP_OK);
    }

    public function deleteUsedCupom($idOrder)
    {
        $usedCupom = CupomUser::where('fk_order', $idOrder)->first();
        if (!$usedCupom) {
            return response()->json(['message' => 'Cupom usado não encontrado'], Response::HTTP_NOT_ACCEPTABLE);
        }

        $usedCupom->delete();
        return response()->json(['message' => 'Cupom usado deletado com sucesso'],Response::HTTP_OK);
    }

    public function getCupomById($id)
    {
        $cupom =  CupomUser::find($id);
        return $cupom;
    }


    public function useCupom(array $data,User $user)
    {
        $idUser = $user['id'];
        $userCupom = new CupomUser;

        $cupom = DiscountCupom::where("nameCupom", $data['nameCupom'])->first();
        if (!$cupom) {
            return response()->json(['message' => 'Cupom não encontrado'], 404);
        }


        if ($cupom->limitUse <= 0) {
            return response()->json(['message' => 'Cupom esgotado'], 400);
        }

        if ($cupom->nameCupom === 'PRIMEIRA10') {
            $usedCupom =  $userCupom->where('fk_user', $idUser)
                ->where('fk_cupom', $cupom->id)
                ->exists();
            if ($usedCupom) {
                return response()->json(['message' => 'Você ja ultizou este cupom!'], 400);
            }
        }


        $order = $this->orderService->orderById($data['order']);

        if (!$order) {
            return response()->json(['message' => 'Pedido não encontrado'], 404);
        }


        $orderItems =  OrderItems::where('fk_order', $order->id)->get();

        $calcDiscount = $order->total / 100 * $cupom->discount;
        $total = round($order->total - $calcDiscount, 2);
        $order->total = $total;
        $order->fk_cupom = $cupom->id;
        $order->save();


        $cupom->limitUse--;
        $cupom->save();

        $userCupom->fk_user = $idUser;
        $userCupom->fk_cupom = $cupom->id;
        $userCupom->fk_order = $data['order'];
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