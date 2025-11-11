<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ["name", "description", "price", "lastPrice", "fkCategory"];
    public $timestamps = false;


    public function category()
    {
        return $this->belongsTo(Category::class, 'fkCategory');
    }
    public function images()
    {
        return $this->hasMany(ImagesProduct::class, 'idProduct');
    }

    public function sizes()
    {
        return $this->hasManyThrough(
            Size::class,         // Modelo final 
            ProductSize::class,  // Modelo intermediário
            'fkProduct',         // FK no ProductSize que referencia Product
            'id',                // PK no Size
            'id',                // PK no Product
            'fkSize'             // FK no ProductSize que referencia Size
        );
    }
    public function Colors()
    {
        return $this->hasManyThrough(
            Colors::class,         // Modelo final 
            ProductColor::class,  // Modelo intermediário
            'fkProduct',         // FK no ProductSize que referencia Product
            'id',                // PK no Size
            'id',                // PK no Product
            'fkColor'             // FK no ProductSize que referencia Size
        );
    }
}
