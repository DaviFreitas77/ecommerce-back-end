<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\RegisterRequest;
use App\Http\Services\UserService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;


#[Group('Auth')]
class RegisterController extends Controller

{
    /**
     * Registra usuario.
     */
    public function __construct(private UserService $userService)
    {
        $this->userService = $userService;
    }
    public function __invoke(RegisterRequest $request)

    {
        $data = $request->validated();

        $user = $this->userService->registerUser($data['email'], $data['password'], $data['name'], $data['lastName'], $data['tel']);

        
        $token = $user->createToken('sanctum')->plainTextToken;
        
        $request->session()->regenerate();
        return response()->json([
            "message" => "conta criada com sucesso",
            'user' => $user,
            'token'=> $token
        ], Response::HTTP_CREATED);
    }
}