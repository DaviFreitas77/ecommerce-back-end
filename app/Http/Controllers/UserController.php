<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Http\Request;

use Laravel\Socialite\Socialite;


class UserController extends Controller
{

    public function __construct(private UserService $userService) {}
    
    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    public function updateUser()
    {
        $validated = request()->validate([
            "name" => ['sometimes', 'string'],
            "email" => ['sometimes', 'string', 'unique:users,email'],
            "password" => ['sometimes', 'string'],
            "lastName" => ['sometimes', 'string'],
            "tel" => ['sometimes', 'string']
        ], [
            "email.unique" => "email ja vinculado a uma conta!",

        ]);
        return $this->userService->updateUser($validated);
    }


   

   
}