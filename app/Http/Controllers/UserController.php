<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\UserService;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;
use Firebase\JWT\JWK;


class UserController extends Controller
{

    public function __construct(private UserService $userService) {}
    public function createUser(Request $request)
    {
        $validated = $request->validate([
            "name" => ['required', 'string'],
            "email" => ['required', 'string', 'unique:users,email'],
            "password" => ['required', 'string'],
            "lastName" => ['required', 'string'],
            "tel" => ['required', 'string']
        ], [
            "name.required" => "o nome é obrigatório",
            "email.required" => "o email é obrigatório",
            "password.required" => "a senha é obrigatório",
            "email.unique" => "email ja vinculado a uma conta!",

        ]);

        $user = $this->userService->registerUser($validated['email'], $validated['password'], $validated['name'], $validated['lastName'], $validated['tel']);

        Auth::login($user);
        $request->session()->regenerate();


        return response()->json([
            "message" => "conta criada com sucesso",
            'user' => $user,
        ]);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }



    public function login(Request $request)
    {
        $credentials  = $request->only("email", "password");

        $emailExisting = User::where("email", $request->email)->first();

        if ($emailExisting && $emailExisting->password === null) {
            return response()->json([
                'message' => 'Este e-mail está vinculado a um login com Google.'
            ], 403);
        }


        $user = $this->userService->loginUser($credentials);

        return response()->json([
            "message" => "login efetuado com sucesso",
            'user' => $user,
        ]);
    }


    public function LoginGoogle(Request $request)
    {


        $token = $request->token;

        if (!$token) {
            return response()->json(['token não encontrado'], 400);
        }
        try {
            $jwks = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v3/certs'), true);

            $keys = JWK::parseKeySet($jwks) ;

            $decoded = JWT::decode($token, $keys);

            $user = User::where('email', $decoded->email)->first();

            if ($user && $user->password === null) {
                Auth::login($user);
                $token = $user->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'token' => $token,
                    'token_type' => 'Bearer',
                    'user' => $user,
                ]);
            }

            $user = new User;
            $user->email = $decoded->email;
            $user->name = $decoded->name;
            $user->role = "user";
            $user->save();


            $tokenJwt = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'token' => $tokenJwt,
                'user' => $user
            ]);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}