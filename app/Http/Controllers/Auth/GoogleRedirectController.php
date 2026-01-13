<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Laravel\Socialite\Socialite;

#[Group('Auth')]
class GoogleRedirectController extends Controller
{
    /**
     * Redirect para o google OAuth
     */
    public function __invoke(Request $request)
    {

        return Socialite::driver('google')->redirect();
    }
}