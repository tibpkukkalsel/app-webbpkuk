<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostGaleri extends Model
{
    protected $table='post_galeri';
    protected $primaryKey='id_galeri';
    protected $fillable=['id_post', 'gambar'];

    public function post()
    {
        return $this->belongsTo(Post::class,'id_post','id_post');
    }
}
