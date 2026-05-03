<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Semester;
use Illuminate\Http\Request;

class RekapNilaiController extends Controller
{
    public function showRekapNilai()
    {
        $semesterAktif = Semester::where('is_aktif', true)->first();

        $nilaiData = Nilai::with(['siswa', 'pengampu.mapel', 'pengampu.kelas'])
            ->when($semesterAktif, function ($q) use ($semesterAktif) {
                $q->whereHas('pengampu', fn($p) => $p->where('semester_id', $semesterAktif->id));
            })
            ->paginate(20);

        $kelasList = Kelas::where('status', 'Aktif')->orderBy('nama_kelas')->get();
        $mapelList = Mapel::where('status', 'Aktif')->orderBy('nama_mapel')->get();

        return view('pages.rekap_nilai', compact('nilaiData', 'kelasList', 'mapelList'));
    }
}