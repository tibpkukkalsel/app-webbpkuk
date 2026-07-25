<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostHashtag extends Model
{
    protected $table='post_hashtag';

    protected $primaryKey='id_post_hashtag';

    protected $fillable=[
        'id_post',
        'id_hashtag'
    ];

    public function post()
    {
        return $this->belongsTo(
            Post::class,
            'id_post',
            'id_post'
        );
    }

    public function hashtag()
    {
        return $this->belongsTo(
            Hashtag::class,
            'id_hashtag',
            'id_hashtag'
        );
    }
}