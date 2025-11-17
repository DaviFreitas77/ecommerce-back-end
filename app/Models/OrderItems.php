<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    protected $table = 'order_items';
    protected $fillable = ['fk_product', 'quantity', 'price', 'fk_order', 'total'];
    public $timestamps = false;
}
