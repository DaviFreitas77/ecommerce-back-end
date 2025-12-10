<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CupomUser extends Model
{
      protected $table = 'cupom_user';
    protected $fillable = ['fk_user', 'fk_cupom', 'fk_order', 'value'];
    public $timestamps = false;
}
