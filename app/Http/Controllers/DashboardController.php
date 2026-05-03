<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $totalSiswa = Siswa::where('status', 'Aktif')->count();
        $totalGuru = Guru::where('status', 'Aktif')->count();
        $totalKelas = Kelas::where('status', 'Aktif')->count();
        $totalMapel = Mapel::where('status', 'Aktif')->count();

        // Data untuk chart distribusi nilai
        $nilaiList = Nilai::all();
        $distribusi = ['A' => 0, 'B' => 0, 'C' => 0, 'D' => 0, 'E' => 0];
        foreach ($nilaiList as $n) {
            $avg = $n->rata_pengetahuan;
            if ($avg === null) continue;
            if ($avg >= 90) $distribusi['A']++;
            elseif ($avg >= 80) $distribusi['B']++;
            elseif ($avg >= 70) $distribusi['C']++;
            elseif ($avg >= 60) $distribusi['D']++;
            else $distribusi['E']++;
        }

        // Kelengkapan nilai
        $totalNilaiSlots = \App\Models\Pengampu::withCount('nilai')->get()->sum(function ($p) {
            return $p->kelas->kelasSiswa()->count();
        });
        $totalNilaiTerisi = $nilaiList->count();

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
