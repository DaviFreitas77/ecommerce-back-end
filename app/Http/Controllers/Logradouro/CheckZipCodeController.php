<?php

namespace App\Http\Controllers\Logradouro;

use App\Http\Controllers\Controller;
use App\Http\Requests\Logradouro\CheckZipCodeRequest;
use App\Http\Services\AdressService;
use Dedoc\Scramble\Attributes\Group;

#[Group('Logradouro')]
class CheckZipCodeController extends Controller
{
    /**
     * Get adress by zipcode.
     */
    public function __construct(private AdressService $adressService) {
        $this->adressService = $adressService;
    }

    public function __invoke(CheckZipCodeRequest $request)
    {   
        $data = $request->validated();
        return $this->adressService->CheckZipCode($data);
    }
}