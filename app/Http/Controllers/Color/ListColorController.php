<?php

namespace App\Http\Controllers\Color;

use App\Http\Controllers\Controller;
use App\Models\Colors;


class ListColorController extends Controller
{
    /**
     * List all colors  
     * 
     */
    public function __invoke()
    {
        $colors = Colors::all();

        return response()->json($colors);
    }
}