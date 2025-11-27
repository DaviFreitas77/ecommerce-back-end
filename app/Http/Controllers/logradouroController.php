<?php

namespace App\Http\Controllers;

use App\Models\logradouro;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class logradouroController extends Controller
{
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

        try {
            $idUser = Auth::user()->id;

            $logradouro = new logradouro;
            $logradouro->type = $validated['street'];
            $logradouro->zip_code = $validated['zip_code'];
            $logradouro->district = $validated['district'];
            $logradouro->city = $validated['city'];
            $logradouro->state = $validated['state'];
            $logradouro->number = $validated['number'];
            $logradouro->fk_user = $idUser;
            $logradouro->save();
        } catch (ErrorException $e) {
            return response()->json($e->getMessage());
        }
    }

    public function fetchLogradouro()
    {
        $idUser = Auth::user()->id;
        $logradouro = logradouro::where('fk_user', $idUser)->get();

        return response()->json(
            $logradouro->map(function ($l) {
                return [
                    'street' => $l->type,
                    'zip_code' => $l->zip_code,
                    'district' => $l->district,
                    'city' => $l->city,
                    'state' => $l->state,
                    'number' => $l->number
                ];
            })
        );
    }
}
