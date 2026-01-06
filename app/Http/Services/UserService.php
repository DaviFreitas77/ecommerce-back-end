<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{

  public function registerUser($email, $password = null, $name,$lastName,$tel)
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

  public function loginUser(array $credentials)
  {
    $emailExisting = User::where("email", $credentials['email'])->first();

    if ($emailExisting && $emailExisting->password === null) {
      return response()->json([
        'message' => 'Este e-mail está vinculado a um login com Google.'
      ], 403);
    }

    if (!Auth::attempt($credentials)) {
      abort(401, "credenciais invalidas");
    }

    $user = Auth::user();

    return $user;
  }
}