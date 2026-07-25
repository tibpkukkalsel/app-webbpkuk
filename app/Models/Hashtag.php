<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hashtag extends Model
{
    protected $table='hashtag';
    protected $primaryKey='id_hashtag';
    protected $fillable=['hashtag'];

     public function posts()
    {
        return $this->belongsToMany(
            Post::class,
            'post_hashtag',
            'id_hashtag',
            'id_post'
        );
    }
}

