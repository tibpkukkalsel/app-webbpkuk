<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Storganisasi extends Model
{
    protected $table='storganisasi';
    protected $primaryKey = 'id_storganisasi';
    public $incrementing = true; // karena auto number
    protected $keyType = 'int'; // karena bigint
    protected $fillable = ['nama', 'keterangan', 'status'];
}
