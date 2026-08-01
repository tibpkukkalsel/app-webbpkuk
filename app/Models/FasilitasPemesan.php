<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FasilitasPemesan extends Model
{
    protected $table = 'fasilitas_pemesan';
    protected $primaryKey = 'id_pemesanan';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nomor_booking',
        'nama_pemohon',
        'nik',
        'instansi',
        'email',
        'no_hp',
        'alamat',
        'keperluan',
        'tanggal_mulai',
        'tanggal_selesai',
        'jam_mulai',
        'jam_selesai',
        'foto_ktp',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public static function generateNomorBooking(): string
    {
        $prefix = 'BK-' . date('Ymd') . '-';
        $count = static::whereDate('created_at', now()->toDateString())->count() + 1;
        
        do {
            $nomor = $prefix . str_pad($count++, 4, '0', STR_PAD_LEFT);
        } while (static::where('nomor_booking', $nomor)->exists());

        return $nomor;
    }

    public function details(): HasMany
    {
        return $this->hasMany(FasilitasPemesananDetail::class, 'id_pemesanan', 'id_pemesanan');
    }

    public function getTotalHargaAttribute(): float
    {
        return (float) $this->details->sum('subtotal');
    }
}
