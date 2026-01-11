<?php

namespace App\Http\Controllers\Size;

use App\Http\Controllers\Controller;
use App\Http\Requests\Size\StoreSizeRequest;
use App\Models\Size;
use Illuminate\Http\Response;

class CreateSizeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreSizeRequest $request)
    {

        $data = $request->validated();

        Size::create($data);
        return response()->json(['message' => 'tamanho criado'], Response::HTTP_CREATED);;
    }
}