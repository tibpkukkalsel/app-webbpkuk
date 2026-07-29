<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroBanner extends Model
{
    protected $table = 'hero_banner';
    protected $primaryKey = 'id_hero_banner';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['judul', 'gambar', 'urutan', 'status'];
}
