<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Semester;
use App\Models\WaliKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $kelasData = $query->with(['waliKelas' => function ($q) use ($semesterAktif) {
            if ($semesterAktif) {
                $q->where('semester_id', $semesterAktif->id)->with('guru');
            }
        }])->withCount(['kelasSiswa' => function ($q) use ($semesterAktif) {
            if ($semesterAktif) {
                $q->where('semester_id', $semesterAktif->id);
            }
        }])->orderBy('nama_kelas')->paginate(20)->withQueryString();

        // Transform agar view tetap bisa mengakses $kelas->wali
        $kelasData->getCollection()->transform(function ($kelas) {
            $kelas->wali = $kelas->waliKelas->first()?->guru;
            return $kelas;
        });

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

        $semesterAktif = Semester::where('is_aktif', true)->first();

        DB::transaction(function() use ($validated, $request, $semesterAktif) {
            $kelas = Kelas::create([
                'kode_kelas' => $validated['kode_kelas'],
                'nama_kelas' => $validated['nama_kelas'],
                'tingkat'    => $validated['tingkat'],
            ]);

            if ($request->filled('wali_id') && $semesterAktif) {
                WaliKelas::create([
                    'guru_id' => $request->wali_id,
                    'kelas_id' => $kelas->id,
                    'semester_id' => $semesterAktif->id,
                ]);
            }
        });

        return redirect()->back()->with('success', 'Data kelas baru berhasil disimpan beserta penugasan wali kelas semester ini.');
    }
}
