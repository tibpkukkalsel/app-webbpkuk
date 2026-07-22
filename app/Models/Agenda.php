<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $table='agenda';
    protected $primaryKey = 'id_agenda';
    public $incrementing = true; // karena auto number
    protected $keyType = 'int'; // karena bigint
    protected $fillable = ['nama', 'slug', 'deskripsi', 'tgl_awal', 'tgl_akhir', 'jam_mulai', 'jam_akhir', 'tempat', 'status'];
}
