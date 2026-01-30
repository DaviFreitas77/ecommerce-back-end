<?php

namespace App\Http\Controllers\Logradouro;

use App\Http\Controllers\Controller;
use App\Http\Requests\Logradouro\StoreLogradouroRequest;
use App\Http\Services\AdressService;
use Dedoc\Scramble\Attributes\Group;

#[Group('Logradouro')]
class CreateLogradouroController extends Controller
{
    /**
     * Create user adress.
     */

    public function __construct(private AdressService $adressService)
    {
        $this->adressService = $adressService;
    }

    public function __invoke(StoreLogradouroRequest $request)
    {
         $data = $request->validated();
         $user = $request->user();
        $this->adressService->createLogradouro($data,$user);
    }
}