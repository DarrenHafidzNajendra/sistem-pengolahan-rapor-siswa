<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Guru extends Model
{
    protected $table = 'guru';

    protected $fillable = [
        'nip',
        'nama_guru',
        'jenis_kelamin',
        'no_hp',
        'status',
    ];

    /**
     * Relasi ke akun user.
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    /**
     * Relasi ke data pengampu.
     */
    public function pengampu(): HasMany
    {
        return $this->hasMany(Pengampu::class);
    }
}
