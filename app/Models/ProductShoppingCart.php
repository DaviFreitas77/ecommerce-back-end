<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductShoppingCart extends Model
{
    protected $table = 'product_shopping_cart';
    protected $fillable = ["fkShoppingCart", "fkProduct", "quantity", "fkColor", 'fkSize'];
    public $timestamps = false;


    public function product()
    {
        return $this->belongsTo(Product::class, 'fkProduct');
    }

    public function color()
    {
        return $this->belongsTo(ProductColor::class, 'fkColor');
    }

    public function size()
    {
        return $this->belongsTo(ProductSize::class, 'fkSize');
    }

    public function cart()
    {
        return $this->belongsTo(ShoppingCart::class, 'fkShoppingCart');
    }
}
