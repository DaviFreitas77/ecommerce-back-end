<?php

namespace App\Http\Controllers;

use App\Http\Services\AdressService;
use App\Models\logradouro;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class logradouroController extends Controller

{

    public function __construct(private AdressService $adressService) {
        $this->adressService = $adressService;
    }

    public function createLogradouro(Request $request)
    {
        $validated = $request->validate([
            'street' => ['required', 'string'],
            'zip_code' => ['required', 'string'],
            'district' => ['required', 'string'],
            'city' => ['required', 'string'],
            'state' => ['required', 'string'],
            'number' => ['required', 'string'],
        ]);

        $this->adressService->createLogradouro($validated);
    }

}