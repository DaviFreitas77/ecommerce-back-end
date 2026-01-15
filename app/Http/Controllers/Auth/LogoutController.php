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
     * Logout usuário (Sanctum SPA)

     */
    public function __invoke(Request $request)
    {
         Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
          return response()->json(['
          "message" => "Logout efetuado com sucesso",
          '], Response::HTTP_OK);
    }
}