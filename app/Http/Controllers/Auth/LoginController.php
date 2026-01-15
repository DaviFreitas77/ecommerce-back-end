<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\LoginRequest;
use App\Http\Services\UserService;
use App\Models\User;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

#[Group('Auth')]
class LoginController extends Controller
{
    /**
     * Login usuario
     */

    public function __construct(private UserService $userService)
    {
        $this->userService = $userService;
    }
    public function __invoke(LoginRequest $request)
    {
       $credentials = $request->validated();

        $user = User::where('email', $credentials['email'])->first();

        if ($user && $user->password === null) {
            return response()->json([
                'message' => 'Este e-mail está vinculado a um login com Google.'
            ], Response::HTTP_FORBIDDEN);
        }

        if (!Auth::guard('web')->attempt($credentials)) {
            return response()->json([
                'message' => 'Credenciais inválidas'
            ], Response::HTTP_UNAUTHORIZED);
        }
    $request->session()->regenerate();
        return response()->json([
            'message' => 'Login efetuado com sucesso',
            'user' => Auth::user(),
        ], Response::HTTP_OK);
    }
}