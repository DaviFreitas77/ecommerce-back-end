<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  protected $table = 'categories';
  protected $fillable = ["name"];
  public $timestamps = false;




  public function subCategories()
  {
    return $this->hasMany(SubCategory::class, 'id_category');
  }
}