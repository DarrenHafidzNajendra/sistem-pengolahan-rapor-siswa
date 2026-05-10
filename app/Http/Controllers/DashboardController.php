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

        // Data untuk chart distribusi nilai
        $distribusi = ['A' => 0, 'B' => 0, 'C' => 0, 'D' => 0, 'E' => 0];
        $distKeterampilan = ['A' => 0, 'B' => 0, 'C' => 0, 'D' => 0, 'E' => 0];
        $distSikap = ['A' => 0, 'B' => 0, 'C' => 0, 'D' => 0]; // SB, B, C, K
        
        // Ambil data Pengetahuan & Keterampilan
        // Perbaikan: Gunakan perhitungan yang lebih adil jika UTS/UAS belum diisi
        $nilaiAggregat = Nilai::leftJoin('komponen_nilai', 'nilai.komponen_nilai_id', '=', 'komponen_nilai.id')
            ->select('nilai.kelas_siswa_id', 'nilai.pengampu_id')
            ->selectRaw("
                AVG(CASE WHEN komponen_nilai.tipe='p_tugas' THEN nilai.skor END) as t_avg,
                AVG(CASE WHEN komponen_nilai.tipe='p_uh' THEN nilai.skor END) as u_avg,
                MAX(CASE WHEN nilai.jenis_nilai='p_uts' THEN nilai.skor END) as uts_val,
                MAX(CASE WHEN nilai.jenis_nilai='p_uas' THEN nilai.skor END) as uas_val,
                AVG(CASE WHEN nilai.jenis_nilai IN ('k_praktik','k_proyek','k_portofolio') THEN nilai.skor END) as k_avg
            ")
            ->whereIn('nilai.jenis_nilai', ['p_uts','p_uas','dynamic','k_praktik','k_proyek','k_portofolio'])
            ->groupBy('nilai.kelas_siswa_id', 'nilai.pengampu_id')
            ->get();

        foreach ($nilaiAggregat as $n) {
            // Hitung Rata-rata Pengetahuan (P) - Rumus Ketat (Bagi 4)
            $nh_vals = array_filter([$n->t_avg, $n->u_avg], fn($v) => !is_null($v));
            $nh = count($nh_vals) > 0 ? array_sum($nh_vals) / count($nh_vals) : 0;
            
            $uts = $n->uts_val ?? 0;
            $uas = $n->uas_val ?? 0;

            // Samakan dengan rumus di Blade: ((2 * NH) + UTS + UAS) / 4
            $p_avg = ((2 * $nh) + $uts + $uas) / 4;
            
            if ($p_avg >= 90) $distribusi['A']++;
            elseif ($p_avg >= 80) $distribusi['B']++;
            elseif ($p_avg >= 70) $distribusi['C']++;
            elseif ($p_avg > 0) $distribusi['D']++;

            // Hitung Rata-rata Keterampilan (K) - Rumus Standar
            if (!is_null($n->k_avg)) {
                $k_avg = $n->k_avg;
                if ($k_avg >= 90) $distKeterampilan['A']++;
                elseif ($k_avg >= 80) $distKeterampilan['B']++;
                elseif ($k_avg >= 70) $distKeterampilan['C']++;
                elseif ($k_avg > 0) $distKeterampilan['D']++;
            }
        }

        // Ambil data Sikap
        $sikapData = Nilai::whereIn('jenis_nilai', ['s_spiritual', 's_sosial'])
            ->selectRaw("skor, COUNT(*) as total")
            ->groupBy('skor')
            ->get();
        
        foreach ($sikapData as $s) {
            $val = (int)$s->skor;
            if ($val == 4) $distSikap['A'] += $s->total;
            elseif ($val == 3) $distSikap['B'] += $s->total;
            elseif ($val == 2) $distSikap['C'] += $s->total;
            elseif ($val == 1) $distSikap['D'] += $s->total;
        }

        // Kelengkapan nilai (Strict Check: Harus ada P, K, dan S)
        $totalNilaiSlots = Pengampu::all()->sum(function ($p) {
            return $p->kelas->kelasSiswa()->count();
        });

        // Kita ambil semua pasangan (siswa, pengampu) yang punya setidaknya 1 baris nilai
        // Lalu kita filter mana yang memiliki ketiga aspek lengkap
        $statusLengkap = Nilai::select('kelas_siswa_id', 'pengampu_id')
            ->selectRaw("
                SUM(CASE WHEN jenis_nilai LIKE 'p_%' OR jenis_nilai = 'dynamic' THEN 1 ELSE 0 END) as p_count,
                SUM(CASE WHEN jenis_nilai LIKE 'k_%' THEN 1 ELSE 0 END) as k_count,
                SUM(CASE WHEN jenis_nilai LIKE 's_%' THEN 1 ELSE 0 END) as s_count
            ")
            ->groupBy('kelas_siswa_id', 'pengampu_id')
            ->get();

        $totalNilaiTerisi = $statusLengkap->filter(function($item) {
            return $item->p_count > 0 && $item->k_count > 0 && $item->s_count > 0;
        })->count();

        return view('pages.dashboard', compact(
            'totalSiswa', 'totalGuru', 'totalKelas', 'totalMapel',
            'distribusi', 'distKeterampilan', 'distSikap',
            'totalNilaiSlots', 'totalNilaiTerisi'
        ));
    }
}
