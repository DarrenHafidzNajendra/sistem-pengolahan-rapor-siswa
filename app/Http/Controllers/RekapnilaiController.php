<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Semester;
use Illuminate\Http\Request;

class RekapNilaiController extends Controller
{
    public function showRekapNilai(Request $request)
    {
        $semesterAktif = Semester::where('is_aktif', true)->first();

        $nilaiData = Nilai::with(['siswa', 'pengampu.mapel', 'pengampu.kelas'])
            ->when($semesterAktif, function ($q) use ($semesterAktif) {
                $q->whereHas('pengampu', fn($p) => $p->where('semester_id', $semesterAktif->id));
            })
            ->when($request->search, function ($q) use ($request) {
                $q->whereHas('siswa', function ($sq) use ($request) {
                    $sq->where('nama_siswa', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->kelas_id, function ($q) use ($request) {
                $q->whereHas('pengampu', function ($pq) use ($request) {
                    $pq->where('kelas_id', $request->kelas_id);
                });
            })
            ->when($request->mapel_id, function ($q) use ($request) {
                $q->whereHas('pengampu', function ($pq) use ($request) {
                    $pq->where('mapel_id', $request->mapel_id);
                });
            })
            ->orderBy(
                \App\Models\Siswa::select('nama_siswa')
                    ->whereColumn('siswa.id', 'nilai.siswa_id')
            )
            ->paginate(20)
            ->withQueryString();

        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $mapelList = Mapel::where('status', 'Aktif')->orderBy('nama_mapel')->get();

        return view('pages.rekap_nilai', compact('nilaiData', 'kelasList', 'mapelList'));
    }
}