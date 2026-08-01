<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FasilitasHalaman extends Model
{
    protected $table = 'fasilitas_halaman';
    protected $primaryKey = 'id_halaman';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'judul',
        'slug',
        'isi',
        'urutan',
        'status',
    ];

    protected $casts = [
        'urutan' => 'integer',
        'status' => 'integer',
    ];

    public static function generateSlug(string $judul, ?int $exceptId = null): string
    {
        $slug = Str::slug($judul);
        $original = $slug;
        $i = 1;

        while (
            static::where('slug', $slug)
                ->when($exceptId, fn($q) => $q->where('id_halaman', '!=', $exceptId))
                ->exists()
        ) {
            $slug = $original . '-' . $i++;
        }

        return $slug;
    }
}
