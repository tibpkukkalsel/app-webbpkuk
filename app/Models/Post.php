<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table='post';
    protected $primaryKey = 'id_post';
    public $incrementing = true; // karena auto number
    protected $keyType = 'int'; // karena bigint
    protected $fillable = ['judul', 'slug', 'isi', 'ringkasan', 'thumbnail', 'jenis', 'status', 'id_kategori', 'id_user', 'view_count'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class,'id_kategori','id_kategori');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'id_user','id');
    }

    public function galeri()
    {
        return $this->hasMany(PostGaleri::class,'id_post','id_post');
    }

    public function hashtags()
    {
        return $this->belongsToMany(
            Hashtag::class,
            'post_hashtag',
            'id_post',
            'id_hashtag'
        );
    }

}

