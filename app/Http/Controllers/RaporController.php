<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Semester;
use Illuminate\Http\Request;

class RaporController extends Controller
{
    public function showRapor()
    {
        $semesterAktif = Semester::where('is_aktif', true)->first();

        $siswaData = Siswa::with(['kelasSiswa' => function ($q) use ($semesterAktif) {
            if ($semesterAktif) {
                $q->where('semester_id', $semesterAktif->id)->with('kelas');
            }
        }, 'nilai' => function ($q) use ($semesterAktif) {
            if ($semesterAktif) {
                $q->whereHas('pengampu', fn($p) => $p->where('semester_id', $semesterAktif->id));
            }
        }])->where('status', 'Aktif')
          ->orderBy('nama_siswa')
          ->paginate(20);

        // Hitung rata-rata dan status kelulusan per siswa
        $siswaData->getCollection()->transform(function ($siswa) {
            $nilaiList = $siswa->nilai;
            if ($nilaiList->isEmpty()) {
                $siswa->rata_rata = null;
                $siswa->status_lulus = '-';
                return $siswa;
            }

            $avgValues = $nilaiList->map(fn($n) => $n->rata_pengetahuan)->filter();
            $siswa->rata_rata = $avgValues->isNotEmpty() ? round($avgValues->avg(), 1) : null;

            if ($siswa->rata_rata === null) {
                $siswa->status_lulus = '-';
            } elseif ($siswa->rata_rata >= 75) {
                $siswa->status_lulus = 'Lulus';
            } elseif ($siswa->rata_rata >= 65) {
                $siswa->status_lulus = 'Kondisional';
            } else {
                $siswa->status_lulus = 'Tidak Lulus';
            }

            return $siswa;
        });

        $kelasList = Kelas::where('status', 'Aktif')->orderBy('nama_kelas')->get();

        return view('pages.data_rapor', compact('siswaData', 'kelasList'));
    }
}
