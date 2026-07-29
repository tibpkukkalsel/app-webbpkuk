<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkTerkait extends Model
{
    protected $table = 'link_terkait';
    protected $primaryKey = 'id_link_terkait';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['nama', 'gambar', 'url', 'urutan', 'status'];
}
