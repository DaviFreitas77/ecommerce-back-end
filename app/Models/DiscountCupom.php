<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountCupom extends Model
{
    protected $table = 'discount_cupoms';
    protected $fillable = ['nameCupom', 'discount', 'validity', 'limitUse'];
    public $timestamps = false;
}
