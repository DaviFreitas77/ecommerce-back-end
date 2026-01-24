<?php

namespace App\Http\Controllers\Upload;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dedoc\Scramble\Attributes\Group;

#[Group('Adm')]
class UploadController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $path = $request->file('image')->store('products', 'public');

        return response()->json([
            'url' => asset('storage/' . $path),
            'path' => $path
        ]);
    }
}