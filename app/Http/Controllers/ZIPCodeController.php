<?php

namespace App\Http\Controllers;

use App\Http\Services\AdressService;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ZIPCodeController extends Controller
{
    public function __construct(private AdressService $adressService)
    {
        $this->adressService = $adressService;
    }


    public function CheckZipCode(Request $request)
    {
        $validated = $request->validate([
            'zipCode' => ['required', 'string']
        ]);

        $response = Http::get('https://viacep.com.br/ws/' . $validated['zipCode'] . '/json/');

        return response()->json($response->json());
    }


    public function myAdress() {
        return $this->adressService->adressByUser();
    }

    public function deleteAdress($id){
        return $this->adressService->deleteAdressById($id);
    }
}