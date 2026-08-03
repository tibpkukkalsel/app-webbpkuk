<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KontakBalasan extends Model
{
    protected $table = 'kontak_balasan';

    protected $fillable = [
        'kontak_id',
        'user_id',
        'subjek_balasan',
        'pesan_balasan',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function kontak(): BelongsTo
    {
        return $this->belongsTo(Kontak::class, 'kontak_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
