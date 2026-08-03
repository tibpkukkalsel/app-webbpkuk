<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProdukUmkm extends Model
{
    protected $table = 'produk_umkm';
    protected $primaryKey = 'id_produkumkm';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_wilayah',
        'nama_produk',
        'nama_umkm',
        'ukuran',
        'ketahanan',
        'pengiriman',
        'foto',
        'status',
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    /**
     * Relasi ke model GisWilayah
     */
    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(GisWilayah::class, 'id_wilayah', 'id_wilayah');
    }
}
