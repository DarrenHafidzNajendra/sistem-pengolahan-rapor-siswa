<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Semester;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function showKelas(Request $request)
    {
        $semesterAktif = Semester::where('is_aktif', true)->first();

        $query = Kelas::query();

        if ($request->filled('search')) {
            $query->where('nama_kelas', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }

        $kelasData = $query->with(['wali'])->withCount(['kelasSiswa' => function ($q) use ($semesterAktif) {
            if ($semesterAktif) {
                $q->where('semester_id', $semesterAktif->id);
            }
        }])->orderBy('nama_kelas')->paginate(20)->withQueryString();

        $guruList = Guru::where('status', 'Aktif')->orderBy('nama_guru')->get();

        return view('pages.data_kelas', compact('kelasData', 'guruList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_kelas' => 'required|string|unique:kelas,kode_kelas',
            'nama_kelas' => 'required|string',
            'tingkat'    => 'required|string',
            'wali_id'    => 'nullable|exists:guru,id',
        ]);

        Kelas::create($validated);

        return redirect()->back()->with('success', 'Data kelas baru berhasil disimpan.');
    }
}
