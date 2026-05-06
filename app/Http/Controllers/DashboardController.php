<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Pengampu;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $totalSiswa = Siswa::where('status', 'Aktif')->count();
        $totalGuru = Guru::where('status', 'Aktif')->count();
        $totalKelas = Kelas::count();
        $totalMapel = Mapel::where('status', 'Aktif')->count();

        // Data untuk chart distribusi nilai (Berdasarkan rata-rata per mapel per siswa)
        $distribusi = ['A' => 0, 'B' => 0, 'C' => 0, 'D' => 0, 'E' => 0];
        
        // Ambil semua nilai akademik dan hitung rata-rata per pengampu & siswa
        $nilaiAggregat = Nilai::whereIn('jenis_nilai', [
                'p_tugas', 'p_uh', 'p_uts', 'p_uas', 
                'k_praktik', 'k_proyek', 'k_portofolio'
            ])
            ->select('kelas_siswa_id', 'pengampu_id')
            ->selectRaw('AVG(skor) as avg_skor')
            ->groupBy('kelas_siswa_id', 'pengampu_id')
            ->get();

        foreach ($nilaiAggregat as $n) {
            $avg = $n->avg_skor;
            if ($avg >= 90) $distribusi['A']++;
            elseif ($avg >= 80) $distribusi['B']++;
            elseif ($avg >= 70) $distribusi['C']++;
            elseif ($avg >= 60) $distribusi['D']++;
            else $distribusi['E']++;
        }

        // Kelengkapan nilai (Estimasi slot vs yang terisi)
        $totalNilaiSlots = Pengampu::all()->sum(function ($p) {
            return $p->kelas->kelasSiswa()->count();
        });
        
        // Nilai dianggap "terisi" jika setidaknya ada 1 baris nilai vertikal untuk kombinasi tersebut
        $totalNilaiTerisi = $nilaiAggregat->count();

        return view('pages.dashboard', compact(
            'totalSiswa',
            'totalGuru',
            'totalKelas',
            'totalMapel',
            'distribusi',
            'totalNilaiSlots',
            'totalNilaiTerisi'
        ));
    }
}
