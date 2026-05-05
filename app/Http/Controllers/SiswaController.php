<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Semester;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function showDataSiswa(Request $request)
    {
        $semesterAktif = Semester::where('is_aktif', true)->first();

        $query = Siswa::query();

        // Filter Search (Nama atau NIS)
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_siswa', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%');
            });
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter Kelas
        if ($request->filled('kelas_id')) {
            $query->whereHas('kelasSiswa', function($q) use ($request, $semesterAktif) {
                $q->where('kelas_id', $request->kelas_id);
                if ($semesterAktif) {
                    $q->where('semester_id', $semesterAktif->id);
                }
            });
        }

        $siswaData = $query->with(['kelasSiswa' => function ($q) use ($semesterAktif) {
            if ($semesterAktif) {
                $q->where('semester_id', $semesterAktif->id)->with('kelas');
            }
        }])->orderBy('nama_siswa')->paginate(20)->withQueryString();

        $kelasList = Kelas::orderBy('nama_kelas')->get();

        return view('pages.data_siswa', compact('siswaData', 'kelasList'));
    }
}
