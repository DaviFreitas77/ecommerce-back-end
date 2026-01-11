<?php

namespace App\Http\Controllers\Size;

use App\Http\Controllers\Controller;
use App\Models\Size;


class ListSizeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
          $sizes = Size::all();

        return response()->json($sizes);
    }
}