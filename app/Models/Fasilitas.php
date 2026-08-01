<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Fasilitas extends Model
{
    protected $table = 'fasilitas';
    protected $primaryKey = 'id_fasilitas';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'thumbnail',
        'nama',
        'slug',
        'kode',
        'deskripsi',
        'kapasitas',
        'jumlah',
        'lokasi',
        'status',
    ];

    public static function generateSlug(string $nama, ?int $exceptId = null): string
    {
        $slug = Str::slug($nama);
        $original = $slug;
        $i = 1;

        while (
            static::where('slug', $slug)
                ->when($exceptId, fn($q) => $q->where('id_fasilitas', '!=', $exceptId))
                ->exists()
        ) {
            $slug = $original . '-' . $i++;
        }

        return $slug;
    }

    public function fotos(): HasMany
    {
        return $this->hasMany(FasilitasFoto::class, 'id_fasilitas', 'id_fasilitas')
            ->orderBy('urutan', 'asc');
    }

    public function tarifs(): HasMany
    {
        return $this->hasMany(FasilitasTarif::class, 'id_fasilitas', 'id_fasilitas')
            ->orderBy('tanggal_mulai', 'desc');
    }

    public function tarifAktif(?string $date = null)
    {
        $targetDate = $date ?? now()->toDateString();
        return $this->hasMany(FasilitasTarif::class, 'id_fasilitas', 'id_fasilitas')
            ->where('status', 1)
            ->where('tanggal_mulai', '<=', $targetDate)
            ->where(function ($query) use ($targetDate) {
                $query->whereNull('tanggal_selesai')
                    ->orWhere('tanggal_selesai', '>=', $targetDate);
            });
    }

    public function pemesanans(): HasMany
    {
        return $this->hasMany(FasilitasPemesan::class, 'id_fasilitas', 'id_fasilitas')
            ->orderBy('created_at', 'desc');
    }
}
