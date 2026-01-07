<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logradouro extends Model
{
    protected $table = 'tb_logradouro';
    protected $fillable = ['fk_user', 'type', 'zip_code', 'district', 'city', 'state', 'number'];
    public $timestamps = false;
}