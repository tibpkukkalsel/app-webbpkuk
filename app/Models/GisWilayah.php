<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GisWilayah extends Model
{
    protected $table = 'gis_wilayah';
    protected $primaryKey = 'id_wilayah';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'kode_bps',
        'nama',
        'jenis',
        'geojson',
        'latitude',
        'longitude',
        'status',
    ];

    protected $casts = [
        'latitude'  => 'float',
        'longitude' => 'float',
        'status'    => 'integer',
    ];

    public function identifikasis(): HasMany
    {
        return $this->hasMany(GisIdentifikasi::class, 'id_wilayah', 'id_wilayah');
    }

    public function realisasis(): HasMany
    {
        return $this->hasMany(GisRealisasi::class, 'id_wilayah', 'id_wilayah');
    }

    public function produkUmkms(): HasMany
    {
        return $this->hasMany(ProdukUmkm::class, 'id_wilayah', 'id_wilayah');
    }
}
