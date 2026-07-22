<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    protected $table='footer';
    protected $primaryKey = 'id_footer';
    public $incrementing = true; // karena auto number
    protected $keyType = 'int'; // karena bigint
    protected $fillable = ['nama', 'keterangan', 'link', 'jenis', 'status'];
}
