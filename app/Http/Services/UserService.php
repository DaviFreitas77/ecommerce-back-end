<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserService
{

  public function registerUser($email, $password = null, $name, $lastName, $tel)
  {
    $user = new User();
    $user->name =  strtolower($name);
    $user->email = strtolower($email);
    $user->lastName = strtolower($lastName);
    $user->tel = $tel;
    $user->password = $password
      ? Hash::make($password)
      : null;
    $user->role = "user";
    $user->save();
    return $user;
  }



  public function updateUser(array $data,User $user)
  {
    $idUser = $user['id'];
    $user = User::find($idUser);


    $user->fill($data);

    $user->save();
    return response()->json([
      "message" => "usuario atualizado com sucesso",
      'user' => $user,
    ]);
  }
}