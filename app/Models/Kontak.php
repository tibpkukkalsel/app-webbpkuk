<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kontak extends Model
{
    protected $table = 'kontak';

    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'subjek',
        'pesan',
        'status',
        'ip_address',
    ];

    public function balasan(): HasMany
    {
        return $this->hasMany(KontakBalasan::class, 'kontak_id', 'id')->orderBy('created_at', 'asc');
    }
}
