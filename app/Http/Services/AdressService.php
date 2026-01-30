<?php

namespace App\Http\Services;

use App\Models\Logradouro;
use App\Models\User;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class AdressService
{


  public function createLogradouro(array $data,User $user)
  {
    try {
      $idUser = $user['id'];
      

      $logradouro = new logradouro;
      $logradouro->type = $data['street'];
      $logradouro->zip_code = $data['zip_code'];
      $logradouro->district = $data['district'];
      $logradouro->city = $data['city'];
      $logradouro->state = $data['state'];
      $logradouro->number = $data['number'];
      $logradouro->fk_user = $idUser;
      $logradouro->save();

      return response()->json(['id' => $logradouro->id],Response::HTTP_CREATED);
    } catch (ErrorException $e) {
      return response()->json($e->getMessage());
    }
  }


  public function adressByUser(User $user)
  {
    $idUser = $user['id'];

    $adressUser = Logradouro::where('fk_user', $idUser)->get();

    return $adressUser;
  }

  public function deleteAdressById($id)
  {
    $adress = Logradouro::find($id);

    if (!$adress) {
      return response()->json([
        'message' => 'Endereço não encontrado.'
      ], Response::HTTP_NOT_FOUND);
    }

    $adress->delete();

    return response()->json([
      'message' => 'Endereço deletado com sucesso.'
    ],Response::HTTP_OK);
  }


  public function CheckZipCode($data)
    {
       
        $response = Http::get('https://viacep.com.br/ws/' . $data['zipCode'] . '/json/');

        return response()->json($response->json());
    }
}