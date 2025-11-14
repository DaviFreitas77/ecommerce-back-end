<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ZIPCodeController extends Controller
{
    public function CheckZipCode(Request $request)
    {
        $validated = $request->validate([
            'zipCode' => ['required', 'string']
        ]);

                $response = Http::get('https://viacep.com.br/ws/' . $validated['zipCode'] . '/json/');

        return response()->json($response->json());
    }
}
