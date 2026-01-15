<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

#[Group('Auth')]
class ProfileController extends Controller
{
    /**
     * Dados do usuário.
     */
    public function __invoke(Request $request)
    {
         return response()->json(
            $request->user(),
            Response::HTTP_OK
        );
    }
}