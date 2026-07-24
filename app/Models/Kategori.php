<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table='kategori';
    protected $primaryKey = 'id_kategori';
    public $incrementing = true; // karena auto number
    protected $keyType = 'int'; // karena bigint
    protected $fillable = ['kategori'];

    public function post()
    {
        return $this->hasMany(Post::class,'id_kategori','id_kategori');
    }

}
