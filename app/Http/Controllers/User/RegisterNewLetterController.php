<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\NewsLetterRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class RegisterNewLetterController extends Controller
{
    /**
     * Add user a newsLetter
     */
    public function __invoke(NewsLetterRequest $request)
    {
         $data = $request->validated();

         $email = $data['email'];
         
         $user = User::where('email', $email)->first();

         if(!$user){
            return response()->json([
                'message' => "Usuaro não encontrado!"
            ],Response::HTTP_NOT_FOUND);
         }

         $user->receive_newsletter = true;
         $user->save();
         return response()->json([
                'message' => "Usuario cadastrado"
            ],Response::HTTP_OK);


    }
}