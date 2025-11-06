<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImagesProduct extends Model
{
    protected $table = 'images_products';
    protected $fillable = ['idProduct', 'images'];
    public $timestamps = false;
}
