<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'video';
    protected $primaryKey = 'id_video';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'judul',
        'slug',
        'youtube_id',
        'ringkasan',
        'id_kategori',
        'status',
        'view_count',
        'id_user'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->youtube_id ? "https://img.youtube.com/vi/{$this->youtube_id}/hqdefault.jpg" : null;
    }

    public function getEmbedUrlAttribute()
    {
        return $this->youtube_id ? "https://www.youtube.com/embed/{$this->youtube_id}" : null;
    }
}
