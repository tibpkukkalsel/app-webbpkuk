<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jabatan extends Model
{
    protected $table = 'jabatan';
    protected $primaryKey = 'id_jabatan';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'jabatan',
        'kelas',
        'status',
    ];

    public function pegawai(): HasMany
    {
        return $this->hasMany(Pegawai::class, 'id_jabatan', 'id_jabatan');
    }
}
