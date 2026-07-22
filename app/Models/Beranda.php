<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beranda extends Model
{
    protected $table='beranda';
    protected $primaryKey = 'id_beranda';
    public $incrementing = true; // karena auto number
    protected $keyType = 'int'; // karena bigint
    protected $fillable = ['nama', 'keterangan_1', 'keterangan_2', 'link', 'jenis', 'status'];
}
