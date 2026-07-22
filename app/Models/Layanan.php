<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table='layanan';
    protected $primaryKey = 'id_layanan';
    public $incrementing = true; // karena auto number
    protected $keyType = 'int'; // karena bigint
    protected $fillable = ['nama', 'deskripsi', 'thumbnail', 'slug', 'status'];
}
