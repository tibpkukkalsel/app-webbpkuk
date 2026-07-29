<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Infografis extends Model
{
    protected $table = 'infografis';
    protected $primaryKey = 'id_infografis';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['judul', 'gambar', 'link', 'urutan', 'status'];
}
