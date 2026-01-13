<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\LoginRequest;
use App\Http\Services\UserService;
use App\Models\User;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Response;

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

        $emailExisting = User::where("email", $request->email)->first();

        if ($emailExisting && $emailExisting->password === null) {
            return response()->json([
                'message' => 'Este e-mail está vinculado a um login com Google.'
            ], Response::HTTP_FORBIDDEN);
        }


        $user = $this->userService->loginUser($credentials);

        return response()->json([
            "message" => "login efetuado com sucesso",
            'user' => $user,
        ], Response::HTTP_OK);
    }
}