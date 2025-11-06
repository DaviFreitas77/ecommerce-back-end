<?php

namespace App\Http\services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class userService
{
  public function construct() {}


  public function registerUser($email, $password, $name)
  {
    $user = new User();
    $user->name =  $name;
    $user->email = $email;
    $user->password = Hash::make($password);
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
