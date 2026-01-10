<?php

namespace App\Http\Controllers\Logradouro;

use App\Http\Controllers\Controller;
use App\Http\Services\AdressService;
use Illuminate\Http\Request;

class DeleteLogradouroController extends Controller
{
    /**
     * Handle the incoming request.
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