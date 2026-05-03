<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nilai extends Model
{
    protected $table = 'nilai';

    protected $fillable = [
        'pengampu_id',
        'siswa_id',
        // Pengetahuan
        'tugas',
        'ulangan_harian',
        'uts',
        'uas',
        // Keterampilan
        'praktik',
        'proyek',
        'portofolio',
        // Sikap
        'sikap_spiritual',
        'sikap_sosial',
        // Catatan
        'catatan_guru',
    ];

    protected function casts(): array
    {
        return [
            'tugas' => 'decimal:2',
            'ulangan_harian' => 'decimal:2',
            'uts' => 'decimal:2',
            'uas' => 'decimal:2',
            'praktik' => 'decimal:2',
            'proyek' => 'decimal:2',
            'portofolio' => 'decimal:2',
        ];
    }

    /**
     * Relasi ke pengampu (guru + mapel + kelas + semester).
     */
    public function pengampu(): BelongsTo
    {
        return $this->belongsTo(Pengampu::class);
    }

    /**
     * Relasi ke siswa.
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    /**
     * Hitung rata-rata pengetahuan.
     */
    public function getRataPengetahuanAttribute(): ?float
    {
        $values = array_filter([
            $this->tugas,
            $this->ulangan_harian,
            $this->uts,
            $this->uas,
        ], fn($v) => $v !== null);

        return count($values) > 0 ? round(array_sum($values) / count($values), 2) : null;
    }

    /**
     * Hitung rata-rata keterampilan.
     */
    public function getRataKeterampilanAttribute(): ?float
    {
        $values = array_filter([
            $this->praktik,
            $this->proyek,
            $this->portofolio,
        ], fn($v) => $v !== null);

        return count($values) > 0 ? round(array_sum($values) / count($values), 2) : null;
    }

    /**
     * Hitung predikat berdasarkan nilai rata-rata.
     */
    public function getPredikatPengetahuanAttribute(): string
    {
        return self::hitungPredikat($this->rata_pengetahuan);
    }

    public function getPredikatKeterampilanAttribute(): string
    {
        return self::hitungPredikat($this->rata_keterampilan);
    }

    /**
     * Helper: konversi nilai ke predikat.
     */
    public static function hitungPredikat(?float $nilai): string
    {
        if ($nilai === null) return '-';
        if ($nilai >= 90) return 'A';
        if ($nilai >= 80) return 'B';
        if ($nilai >= 70) return 'C';
        return 'D';
    }
}
