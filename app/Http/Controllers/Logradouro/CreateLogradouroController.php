<?php

namespace App\Http\Controllers\Logradouro;

use App\Http\Controllers\Controller;
use App\Http\Requests\Logradouro\StoreLogradouroRequest;
use App\Http\Services\AdressService;

class CreateLogradouroController extends Controller
{
    /**
     * Handle the incoming request.
     */

    public function __construct(private AdressService $adressService)
    {
        $this->adressService = $adressService;
    }

    public function __invoke(StoreLogradouroRequest $request)
    {
         $data = $request->validated();
        $this->adressService->createLogradouro($data);
    }
}