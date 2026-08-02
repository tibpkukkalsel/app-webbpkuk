<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GisJenisDiklat extends Model
{
    protected $table = 'gis_jenis_diklat';
    protected $primaryKey = 'id_jenis_diklat';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'jenis_sdm',
        'nama',
        'deskripsi',
        'status',
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    public function identifikasiDetails(): HasMany
    {
        return $this->hasMany(GisIdentifikasiDetail::class, 'id_jenis_diklat', 'id_jenis_diklat');
    }

    public function realisasis(): HasMany
    {
        return $this->hasMany(GisRealisasi::class, 'id_jenis_diklat', 'id_jenis_diklat');
    }
}
