<?php

namespace App\Http\Controllers\Logradouro;

use App\Http\Controllers\Controller;
use App\Http\Services\AdressService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;

#[Group('Logradouro')]
class LogradouroUserController extends Controller
{
    /**
     * get adress by user
     */

  public function __construct(private AdressService $adressService)
    {
        $this->adressService = $adressService;
    }

    public function __invoke(Request $request)
    {
        $user = $request->user();
        return $this->adressService->adressByUser($user);
    }
}