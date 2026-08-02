<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GisIdentifikasi extends Model
{
    protected $table = 'gis_identifikasi';
    protected $primaryKey = 'id_identifikasi';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_wilayah',
        'tahun',
        'jenis_sdm',
        'jumlah_responden',
        'keterangan',
        'status',
    ];

    protected $casts = [
        'tahun'            => 'integer',
        'jumlah_responden' => 'integer',
        'status'           => 'integer',
    ];

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(GisWilayah::class, 'id_wilayah', 'id_wilayah');
    }

    public function details(): HasMany
    {
        return $this->hasMany(GisIdentifikasiDetail::class, 'id_identifikasi', 'id_identifikasi');
    }
}
