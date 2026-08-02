<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GisIdentifikasiDetail extends Model
{
    protected $table = 'gis_identifikasi_detail';
    protected $primaryKey = 'id_detail';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_identifikasi',
        'id_jenis_diklat',
        'jumlah_responden',
        'keterangan',
    ];

    protected $casts = [
        'jumlah_responden' => 'integer',
    ];

    public function identifikasi(): BelongsTo
    {
        return $this->belongsTo(GisIdentifikasi::class, 'id_identifikasi', 'id_identifikasi');
    }

    public function jenisDiklat(): BelongsTo
    {
        return $this->belongsTo(GisJenisDiklat::class, 'id_jenis_diklat', 'id_jenis_diklat');
    }
}
