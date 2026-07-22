<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    protected $table='fasilitas';
    protected $primaryKey = 'id_fasilitas';
    public $incrementing = true; // karena auto number
    protected $keyType = 'int'; // karena bigint
    protected $fillable = ['nama', 'gambar', 'keterangan', 'status'];
}
