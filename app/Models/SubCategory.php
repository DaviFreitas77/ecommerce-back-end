<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $table = 'sub_categories';
    protected $fillable = ['id_category','name'];
    public $timestamps =  false;

    


    public function category(){
        return $this->belongsTo(Category::class, 'id_category');
    }
}