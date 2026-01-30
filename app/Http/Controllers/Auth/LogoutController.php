<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

#[Group('Auth')]
class LogoutController extends Controller
{
    /**
     * Logout usuário 

     */
    public function __invoke(Request $request)
    {
         
        $request->user()->currentAccessToken()->delete();
          return response()->json(['
          "message" => "Logout efetuado com sucesso",
          '], Response::HTTP_OK);
    }
}