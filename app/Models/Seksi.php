<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seksi extends Model
{
    protected $table = 'seksi';
    protected $primaryKey = 'id_seksi';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'seksi',
        'status',
    ];

    public function pegawai(): HasMany
    {
        return $this->hasMany(Pegawai::class, 'id_seksi', 'id_seksi');
    }
}
