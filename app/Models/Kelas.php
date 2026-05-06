<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = [
        'kode_kelas',
        'nama_kelas',
        'tingkat',
    ];

    /**
     * Relasi ke penugasan wali kelas.
     */
    public function waliKelas(): HasMany
    {
        return $this->hasMany(WaliKelas::class);
    }

    /**
     * Relasi ke penempatan siswa (pivot kelas_siswa).
     */
    public function kelasSiswa(): HasMany
    {
        return $this->hasMany(KelasSiswa::class);
    }

    /**
     * Relasi many-to-many ke siswa melalui pivot.
     */
    public function siswa(): BelongsToMany
    {
        return $this->belongsToMany(Siswa::class, 'kelas_siswa')
                    ->withPivot('semester_id')
                    ->withTimestamps();
    }

    /**
     * Relasi ke data pengampu.
     */
    public function pengampu(): HasMany
    {
        return $this->hasMany(Pengampu::class);
    }
}
