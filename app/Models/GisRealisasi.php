<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GisRealisasi extends Model
{
    protected $table = 'gis_realisasi';
    protected $primaryKey = 'id_realisasi';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_wilayah',
        'id_jenis_diklat',
        'tahun',
        'jumlah_peserta',
        'jumlah_kegiatan',
        'keterangan',
    ];

    protected $casts = [
        'tahun'           => 'integer',
        'jumlah_peserta'  => 'integer',
        'jumlah_kegiatan' => 'integer',
    ];

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(GisWilayah::class, 'id_wilayah', 'id_wilayah');
    }

    public function jenisDiklat(): BelongsTo
    {
        return $this->belongsTo(GisJenisDiklat::class, 'id_jenis_diklat', 'id_jenis_diklat');
    }
}
