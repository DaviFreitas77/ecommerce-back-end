<?php

namespace App\Http\Services;

use App\Models\CupomUser;

class CupomService
{

    public function deleteUsedCupom($idOrder)
    {
        $usedCupom = CupomUser::where('fk_order', $idOrder)->first();
        if (!$usedCupom) {
            return response()->json(['message' => 'Cupom usado não encontrado'], 404);
        }

        $usedCupom->delete();
        return response()->json(['message' => 'Cupom usado deletado com sucesso']);
    }

    public function getCupomById($id)
    {
        $cupom =  CupomUser::find($id);
        return $cupom;
    }


}
