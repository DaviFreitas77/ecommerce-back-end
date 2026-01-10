<?php

namespace App\Http\Controllers\Logradouro;

use App\Http\Controllers\Controller;
use App\Http\Services\AdressService;
use Dedoc\Scramble\Attributes\Group;



#[Group('Logradouro')]
class DeleteLogradouroController extends Controller
{
    /**
     * Delete user adress
     */

    public function __construct(private AdressService $adressService)
    {
        $this->adressService = $adressService;
    }

    public function __invoke($id)
    {
        return $this->adressService->deleteAdressById($id);
    }
}