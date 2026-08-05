<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'kategori',
        'slug',
    ];

    protected static function booted()
    {
        static::creating(function ($item) {
            if (empty($item->slug) && !empty($item->kategori)) {
                $item->slug = Str::slug($item->kategori);
            }
        });

        static::updating(function ($item) {
            if (!empty($item->kategori)) {
                $item->slug = Str::slug($item->kategori);
            }
        });
    }

    public function post()
    {
        return $this->hasMany(Post::class, 'id_kategori', 'id_kategori');
    }
}
