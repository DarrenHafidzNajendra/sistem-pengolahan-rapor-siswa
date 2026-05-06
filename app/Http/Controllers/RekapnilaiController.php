<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Semester;
use App\Models\KelasSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekapNilaiController extends Controller
{
    public function showRekapNilai(Request $request)
    {
        $semesterAktif = Semester::where('is_aktif', true)->first();

        // Menggunakan Query Builder untuk agregasi Pivot agar performa optimal
        $query = Nilai::query()
            ->select('kelas_siswa_id', 'pengampu_id')
            // Pivot vertikal ke horizontal untuk rekap
            ->selectRaw("MAX(CASE WHEN jenis_nilai = 'p_tugas' THEN skor END) as tugas")
            ->selectRaw("MAX(CASE WHEN jenis_nilai = 'p_uts' THEN skor END) as uts")
            ->selectRaw("MAX(CASE WHEN jenis_nilai = 'p_uas' THEN skor END) as uas")
            ->selectRaw("MAX(CASE WHEN jenis_nilai = 'catatan' THEN catatan_guru END) as catatan_guru")
            ->selectRaw("ROUND(AVG(CASE WHEN jenis_nilai NOT IN ('s_spiritual', 's_sosial', 'catatan') THEN skor END), 2) as rata_pengetahuan")
            ->groupBy('kelas_siswa_id', 'pengampu_id');

        // Filter berdasarkan Semester Aktif
        if ($semesterAktif) {
            $query->whereHas('pengampu', fn($q) => $q->where('semester_id', $semesterAktif->id));
        }

        // Filter Pencarian & Dropdown
        if ($request->search) {
            $query->whereHas('kelasSiswa.siswa', function ($q) use ($request) {
                $q->where('nama_siswa', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->kelas_id) {
            $query->whereHas('pengampu', fn($q) => $q->where('kelas_id', $request->kelas_id));
        }

        if ($request->mapel_id) {
            $query->whereHas('pengampu', fn($q) => $q->where('mapel_id', $request->mapel_id));
        }

        $nilaiData = $query->with(['kelasSiswa.siswa', 'pengampu.mapel', 'pengampu.kelas'])
            ->paginate(20)
            ->withQueryString();

        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $mapelList = Mapel::where('status', 'Aktif')->orderBy('nama_mapel')->get();

        return view('pages.rekap_nilai', compact('nilaiData', 'kelasList', 'mapelList'));
    }
}