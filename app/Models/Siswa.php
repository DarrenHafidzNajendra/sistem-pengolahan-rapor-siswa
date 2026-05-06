<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'nis',
        'nama_siswa',
        'jenis_kelamin',
        'status',
    ];

    protected function casts(): array
    {
        return [
        ];
    }

    /**
     * Relasi ke penempatan kelas (pivot kelas_siswa).
     */
    public function kelasSiswa(): HasMany
    {
        return $this->hasMany(KelasSiswa::class);
    }

    /**
     * Relasi many-to-many ke kelas melalui pivot.
     */
    public function kelas(): BelongsToMany
    {
        return $this->belongsToMany(Kelas::class, 'kelas_siswa')
                    ->withPivot('semester_id')
                    ->withTimestamps();
    }

    /**
     * Relasi ke nilai.
     */
    public function nilai(): HasMany
    {
        return $this->hasMany(Nilai::class);
    }


}
