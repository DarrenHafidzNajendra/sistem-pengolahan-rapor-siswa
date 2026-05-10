<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KomponenNilai extends Model
{
    protected $table = 'komponen_nilai';

    protected $fillable = [
        'pengampu_id',
        'nama_komponen',
        'tipe',
    ];

    public function pengampu(): BelongsTo
    {
        return $this->belongsTo(Pengampu::class);
    }

    public function nilai(): HasMany
    {
        return $this->hasMany(Nilai::class, 'komponen_nilai_id');
    }
}
