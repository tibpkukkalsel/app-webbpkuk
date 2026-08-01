<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FasilitasPemesananDetail extends Model
{
    protected $table = 'fasilitas_pemesanan_detail';
    protected $primaryKey = 'id_detail';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_pemesanan',
        'id_fasilitas',
        'jumlah',
        'tarif',
        'subtotal',
        'keterangan',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'tarif' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function pemesanan(): BelongsTo
    {
        return $this->belongsTo(FasilitasPemesan::class, 'id_pemesanan', 'id_pemesanan');
    }

    public function fasilitas(): BelongsTo
    {
        return $this->belongsTo(Fasilitas::class, 'id_fasilitas', 'id_fasilitas');
    }
}
