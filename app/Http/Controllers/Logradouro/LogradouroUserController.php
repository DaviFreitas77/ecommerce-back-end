<?php

namespace App\Http\Controllers\Logradouro;

use App\Http\Controllers\Controller;
use App\Http\Services\AdressService;
use Illuminate\Http\Request;

class LogradouroUserController extends Controller
{
    /**
     * Handle the incoming request.
     */

  public function __construct(private AdressService $adressService)
    {
        $this->adressService = $adressService;
    }

    public function __invoke()
    {
        return $this->adressService->adressByUser();
    }
}