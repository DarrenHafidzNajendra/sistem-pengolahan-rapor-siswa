<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelas = [
            [
                'kode_kelas' => 'X-IPA-1',
                'nama_kelas' => 'X IPA 1',
                'tahun_ajaran' => '2024/2025',
            ],
            [
                'kode_kelas' => 'X-IPA-2',
                'nama_kelas' => 'X IPA 2',
                'tahun_ajaran' => '2024/2025',
            ],
            [
                'kode_kelas' => 'X-IPS-1',
                'nama_kelas' => 'X IPS 1',
                'tahun_ajaran' => '2024/2025',
            ],
            [
                'kode_kelas' => 'XI-IPA-1',
                'nama_kelas' => 'XI IPA 1',
                'tahun_ajaran' => '2024/2025',
            ],
        ];

        foreach ($kelas as $k) {
            Kelas::create($k);
        }
    }
}
