<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\UserService;
use App\Models\User;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Socialite;

#[Group('Auth')]
class GoogleCallbackController extends Controller
{
    /**
     * Callback Google OAuth.
     */


    public function __construct(private UserService $userService)
    {
        $this->userService = $userService;
    }
    public function __invoke(Request $request)
    {
        $googleUser = Socialite::driver('google')->user();

        $email = $googleUser->email;

        $user = User::where('email', $email)->first();
        if ($user && $user->password !== null) {
            return redirect(
                env('SANCTUM_FRONTEND_URL') . '/?loginModal=true&error=not_google'
            );
        }

        if (!$user) {
            $user = $this->userService->registerUser($googleUser->email, null, $googleUser->user['given_name'], $googleUser->user['family_name'], null);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect(
            env('SANCTUM_FRONTEND_URL')
        );
    }
}