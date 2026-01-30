<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = ["name", "description", "price", "lastPrice", "fkCategory","fkSubcategory"];
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
        return $this->belongsToMany(
            Size::class,      // Modelo relacionado
            'product_sizes',  // Tabela pivot
            'fkProduct',      // FK deste model na pivot
            'fkSize'          // FK do outro model na pivot
        );
    }

    public function colors()
    {
        return $this->belongsToMany(
            Colors::class,
            'product_colors',
            'fkProduct',
            'fkColor'
        );
    }

}