<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Seksi extends Model
{
    protected $table = 'seksi';
    protected $primaryKey = 'id_seksi';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'seksi',
        'slug',
        'status',
    ];

    protected static function booted()
    {
        static::creating(function ($seksi) {
            if (empty($seksi->slug) && !empty($seksi->seksi)) {
                $seksi->slug = Str::slug($seksi->seksi);
            }
        });

        static::updating(function ($seksi) {
            if (!empty($seksi->seksi)) {
                $seksi->slug = Str::slug($seksi->seksi);
            }
        });
    }

    public function pegawai(): HasMany
    {
        return $this->hasMany(Pegawai::class, 'id_seksi', 'id_seksi');
    }
}
