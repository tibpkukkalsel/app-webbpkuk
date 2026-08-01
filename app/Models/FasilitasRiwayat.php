<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class FasilitasRiwayat extends Model
{
    protected $table = 'fasilitas_riwayat';
    protected $primaryKey = 'id_riwayat';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_pemesanan',
        'nomor_booking',
        'id_fasilitas',
        'user_id',
        'aktivitas',
        'deskripsi',
    ];

    public static function catatLog(
        string $aktivitas,
        ?string $deskripsi = null,
        ?int $idPemesanan = null,
        ?int $idFasilitas = null,
        ?string $nomorBooking = null,
        ?int $userId = null
    ): static {
        return static::create([
            'id_pemesanan'  => $idPemesanan,
            'nomor_booking' => $nomorBooking,
            'id_fasilitas'  => $idFasilitas,
            'user_id'       => $userId ?? Auth::id(),
            'aktivitas'     => $aktivitas,
            'deskripsi'     => $deskripsi,
        ]);
    }

    public function pemesanan(): BelongsTo
    {
        return $this->belongsTo(FasilitasPemesan::class, 'id_pemesanan', 'id_pemesanan');
    }

    public function fasilitas(): BelongsTo
    {
        return $this->belongsTo(Fasilitas::class, 'id_fasilitas', 'id_fasilitas');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
