<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TahunAjaran extends Model
{
    protected $table = 'tahun_ajaran';

    protected $fillable = [
        'nama',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_aktif',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
            'is_aktif' => 'boolean',
        ];
    }

    /**
     * Relasi ke semester.
     */
    public function semester(): HasMany
    {
        return $this->hasMany(Semester::class);
    }

    /**
     * Scope: hanya tahun ajaran aktif.
     */
    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }
}
