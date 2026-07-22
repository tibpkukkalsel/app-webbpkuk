<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Identitas extends Model
{
    protected $table='identitas';
    protected $primaryKey = 'id_identitas';
    public $incrementing = true; // karena auto number
    protected $keyType = 'int'; // karena bigint
    protected $fillable = ['nama', 'keterangan', 'link', 'jenis', 'status'];
}
