<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GisTarget extends Model
{
    protected $table = 'gis_target';
    protected $primaryKey = 'id_target';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_wilayah',
        'id_jenis_diklat',
        'tahun',
        'target_peserta',
        'keterangan',
        'status',
    ];

    protected $casts = [
        'tahun'          => 'integer',
        'target_peserta' => 'integer',
        'status'         => 'boolean',
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
