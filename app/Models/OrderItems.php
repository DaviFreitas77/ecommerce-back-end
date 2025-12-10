<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    protected $table = 'order_items';
    protected $fillable = ['fk_product', 'quantity', 'price', 'fk_order', 'total', 'fk_color', 'fk_size'];
    public $timestamps = false;




    public function product()
    {
        return $this->belongsTo(Product::class, 'fk_product');
    }
    public function color()
    {
        return $this->belongsTo(Colors::class, 'fk_color');
    }
    public function size()
    {
        return $this->belongsTo(Size::class, 'fk_size');
    }
}
