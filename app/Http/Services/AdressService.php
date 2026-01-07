<?php

namespace App\Http\Services;

use App\Models\Logradouro;
use Illuminate\Support\Facades\Auth;

class AdressService
{

  public function adressByUser()
  {
    $idUser = Auth::user()->id;

    $adressUser = Logradouro::where('fk_user', $idUser)->get();

    return $adressUser;
  }

  public function deleteAdressById($id)
  {
    $adress = Logradouro::find($id);

    if (!$adress) {
      return response()->json([
        'message' => 'Endereço não encontrado.'
      ], 404);
    }

    $adress->delete();

    return response()->json([
      'message' => 'Endereço deletado com sucesso.'
    ]);
  }
}