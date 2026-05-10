<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengampu extends Model
{
    protected $table = 'pengampu';

    protected $fillable = [
        'guru_id',
        'mapel_id',
        'kelas_id',
        'semester_id',
        'kkm',
        'status',
    ];

    /**
     * Relasi ke guru.
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    /**
     * Relasi ke mata pelajaran.
     */
    public function mapel(): BelongsTo
    {
        return $this->belongsTo(Mapel::class);
    }

    /**
     * Relasi ke kelas.
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    /**
     * Relasi ke semester.
     */
    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    /**
     * Relasi ke nilai siswa.
     */
    public function nilai(): HasMany
    {
        return $this->hasMany(Nilai::class);
    }

    public function komponenNilai(): HasMany
    {
        return $this->hasMany(KomponenNilai::class);
    }

    /**
     * Relasi ke presensi.
     */
    public function presensi(): HasMany
    {
        return $this->hasMany(Presensi::class);
    }
}
