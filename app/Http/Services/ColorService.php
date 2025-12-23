<?php

namespace App\Http\Services;

use App\Models\Colors;

class ColorService
{

   public function getColorById($id){
        $colorById = Colors::find($id);

        return $colorById->name;
   }


}
