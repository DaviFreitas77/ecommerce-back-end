<?php

namespace App\Http\Controllers\Color;

use App\Http\Controllers\Controller;
use App\Http\Requests\Color\StoreColorRequest;
use App\Models\Colors;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Response;

#[Group('colors')]
class CreateColorController extends Controller
{
    /**
     * Create color
     */
    public function __invoke(StoreColorRequest $request)
    {
        $data = $request->validated();

        Colors::create([
            'name' => $data['name'],
        ]);

        return response()->json((['message' => 'cor criada com sucesso']), Response::HTTP_CREATED);
    }
}