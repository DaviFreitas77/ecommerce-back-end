<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'tb_order';
    protected $fillable = ['number_order', 'fk_user', 'status', 'total', 'payment_method', 'fk_cupom', 'created_at',];
    public $timestamps = false;




    public function user()
    {
        return $this->belongsTo(User::class, 'fk_user');
    }

    public function cupom()
    {
        return $this->belongsTo(DiscountCupom::class, 'fk_cupom');
    }

    protected $casts = [
    'created_at' => 'datetime',
];
}