<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

#[Group('Auth')]
class LogoutController extends Controller
{
    /**
     * Logout usuario
     */
    public function __invoke(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json([
            'message' => 'Logout realizado com sucesso'
        ], 200);
    }
}