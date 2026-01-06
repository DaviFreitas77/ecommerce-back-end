<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Socialite;


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


    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback(Request $request)
    {
        $googleUser = Socialite::driver('google')->user();

        $email = $googleUser->email;

        $user = User::where('email', $email)->first();


        if (!$user) {
            $newUser = $this->userService->registerUser($googleUser->email, null, $googleUser->user['given_name'], $googleUser->user['family_name'], null);

            Auth::login($newUser);
            $request->session()->regenerate();
        }

        if ($user && $user->password !== null) {
            return redirect(
                env('SANCTUM_FRONTEND_URL') . '/?loginModal=true&error=not_google'
            );
        }

        if ($user && $user->password == null) {
            Auth::login($user);
        }

        return redirect(
            env('SANCTUM_FRONTEND_URL')
        );
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json([
            'message' => 'Logout realizado com sucesso'
        ], 200);
    }
}