<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Semester;
use Illuminate\Http\Request;

class RaporController extends Controller
{
    public function showRapor(Request $request)
    {
        $semesterAktif = Semester::where('is_aktif', true)->first();

        $query = Siswa::with(['kelasSiswa' => function ($q) use ($semesterAktif) {
            if ($semesterAktif) {
                $q->where('semester_id', $semesterAktif->id)->with('kelas');
            }
        }, 'nilai' => function ($q) use ($semesterAktif) {
            if ($semesterAktif) {
                $q->whereHas('pengampu', fn($p) => $p->where('semester_id', $semesterAktif->id));
            }
        }])->where('status', 'Aktif');

        if ($request->filled('search')) {
            $query->where('nama_siswa', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kelas_id')) {
            $kelasId = $request->kelas_id;
            $query->whereHas('kelasSiswa', function ($q) use ($kelasId, $semesterAktif) {
                $q->where('kelas_id', $kelasId);
                if ($semesterAktif) {
                    $q->where('semester_id', $semesterAktif->id);
                }
            });
        }

        $siswaData = $query->orderBy('nama_siswa')->paginate(20)->withQueryString();

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

        $kelasList = Kelas::orderBy('nama_kelas')->get();

        return view('pages.data_rapor', compact('siswaData', 'kelasList'));
    }
}
