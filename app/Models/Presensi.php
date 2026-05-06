<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Presensi extends Model
{
    protected $table = 'presensi';

    protected $fillable = [
        'kelas_siswa_id',
        'pengampu_id',
        'tanggal',
        'status',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    /**
     * Relasi ke pengampu.
     */
    public function pengampu(): BelongsTo
    {
        return $this->belongsTo(Pengampu::class);
    }

    /**
     * Relasi ke riwayat kelas siswa.
     */
    public function kelasSiswa(): BelongsTo
    {
        return $this->belongsTo(KelasSiswa::class, 'kelas_siswa_id');
    }
}
