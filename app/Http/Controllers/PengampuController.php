<?php

namespace App\Http\Controllers;

use App\Models\Pengampu;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Kelas;
use App\Models\Semester;
use Illuminate\Http\Request;

class PengampuController extends Controller
{
    public function showPengampu()
    {
        $semesterAktif = Semester::where('is_aktif', true)->first();

        $pengampus = Pengampu::with(['guru', 'mapel', 'kelas', 'semester.tahunAjaran'])
            ->when($semesterAktif, fn($q) => $q->where('semester_id', $semesterAktif->id))
            ->orderBy('id')
            ->paginate(20);

        $gurus = Guru::where('status', 'Aktif')->orderBy('nama_guru')->get();
        $mapels = Mapel::where('status', 'Aktif')->orderBy('nama_mapel')->get();
        $kelas = Kelas::where('status', 'Aktif')->orderBy('nama_kelas')->get();
        $semesters = Semester::with('tahunAjaran')->orderByDesc('id')->get();

        return view('pages.pengampu', compact('pengampus', 'gurus', 'mapels', 'kelas', 'semesters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'mapel_id' => 'required|exists:mapel,id',
            'kelas_id' => 'required|exists:kelas,id',
            'semester_id' => 'required|exists:semester,id',
            'kkm' => 'nullable|integer|min:0|max:100',
        ]);

        Pengampu::create([
            'guru_id' => $request->guru_id,
            'mapel_id' => $request->mapel_id,
            'kelas_id' => $request->kelas_id,
            'semester_id' => $request->semester_id,
            'kkm' => $request->kkm ?? 75,
        ]);

        return redirect()->back()->with('success', 'Pengampu berhasil ditambahkan.');
    }
}
