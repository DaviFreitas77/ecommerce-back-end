<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'tb_order';
    protected $fillable = ['number_order','fk_user','status','total','payment_method','fk_cupom','created_at',];
    public $timestamps = false;
}
