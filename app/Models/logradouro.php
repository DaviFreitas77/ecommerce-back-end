<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class logradouro extends Model
{
    protected $table = 'tb_logradouro';
    protected $fillable = ['fk_user', 'name', 'type', 'zip_code', 'district', 'city', 'state', 'number'];
    public $timestamps = false;
}
