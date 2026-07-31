<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pegawai extends Model
{
    protected $table = 'pegawai';
    protected $primaryKey = 'id_pegawai';
    public $incrementing = true;
    protected $keyType = 'int';

    public const JENIS_MAP = [
        '1' => 'PNS',
        '2' => 'PPPK Penuh Waktu',
        '3' => 'PPPK Paruh Waktu',
        '4' => 'PJLP',
    ];

    protected $fillable = [
        'nama',
        'nip',
        'jenis',
        'foto',
        'id_jabatan',
        'id_seksi',
        'status',
    ];

    public function getJenisTextAttribute(): string
    {
        return self::JENIS_MAP[(string)$this->jenis] ?? '-';
    }

    public function jabatan(): BelongsTo
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan', 'id_jabatan');
    }

    public function seksi(): BelongsTo
    {
        return $this->belongsTo(Seksi::class, 'id_seksi', 'id_seksi');
    }
}
