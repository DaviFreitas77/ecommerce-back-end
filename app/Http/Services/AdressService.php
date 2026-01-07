<?php

namespace App\Http\Services;

use App\Models\Logradouro;
use ErrorException;
use Illuminate\Support\Facades\Auth;

class AdressService
{


  public function createLogradouro(array $data)
  {
    try {
      $idUser = Auth::user()->id;

      $logradouro = new logradouro;
      $logradouro->type = $data['street'];
      $logradouro->zip_code = $data['zip_code'];
      $logradouro->district = $data['district'];
      $logradouro->city = $data['city'];
      $logradouro->state = $data['state'];
      $logradouro->number = $data['number'];
      $logradouro->fk_user = $idUser;
      $logradouro->save();

      return response()->json(['id' => $logradouro->id]);
    } catch (ErrorException $e) {
      return response()->json($e->getMessage());
    }
  }


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