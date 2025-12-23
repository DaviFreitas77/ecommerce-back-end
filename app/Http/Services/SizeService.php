<?php

namespace App\Http\Services;

use App\Models\Size;

class SizeService
{

   public function getSizeById($id){
        $sizeById = Size::find($id);

        return $sizeById->name;
   }


}
