<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Semester;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function showDataSiswa()
    {
        $semesterAktif = Semester::where('is_aktif', true)->first();

        $siswaData = Siswa::with(['kelasSiswa' => function ($q) use ($semesterAktif) {
            if ($semesterAktif) {
                $q->where('semester_id', $semesterAktif->id)->with('kelas');
            }
        }])->orderBy('nama_siswa')->paginate(20);

        $kelasList = Kelas::where('status', 'Aktif')->orderBy('nama_kelas')->get();

        return view('pages.data_siswa', compact('siswaData', 'kelasList'));
    }
}
