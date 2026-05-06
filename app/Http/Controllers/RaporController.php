<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Semester;
use App\Models\WaliKelas;
use App\Models\KelasSiswa;
use Illuminate\Http\Request;

class RaporController extends Controller
{
    public function showRapor(Request $request)
    {
        $semesterAktif = Semester::where('is_aktif', true)->first();

        $query = Siswa::with(['kelasSiswa' => function ($q) use ($semesterAktif) {
            if ($semesterAktif) {
                $q->where('semester_id', $semesterAktif->id)->with(['kelas', 'nilai']);
            }
        }])
        ->where('status', 'Aktif');

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

        // Restriksi Akses: Hanya Wali Kelas yang bisa melihat rapor kelasnya
        $user = auth()->user();
        if (!$user->isAdmin()) {
            if ($user->isWaliKelas()) {
                $managedKelasIds = WaliKelas::where('guru_id', $user->guru_id)->pluck('kelas_id')->toArray();
                
                $query->whereHas('kelasSiswa', function ($q) use ($managedKelasIds, $semesterAktif) {
                    $q->whereIn('kelas_id', $managedKelasIds);
                    if ($semesterAktif) {
                        $q->where('semester_id', $semesterAktif->id);
                    }
                });
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        $siswaData = $query->orderBy('nama_siswa')->paginate(20)->withQueryString();

        // Hitung rata-rata dan status kelulusan per siswa (Aggregasi Vertikal)
        $siswaData->getCollection()->transform(function ($siswa) {
            $ks = $siswa->kelasSiswa->first();
            if (!$ks || $ks->nilai->isEmpty()) {
                $siswa->rata_rata = null;
                $siswa->status_lulus = '-';
                return $siswa;
            }

            // Kelompokkan nilai per mata pelajaran (pengampu) untuk dihitung rata-ratanya
            $nilaiPerMapel = $ks->nilai->groupBy('pengampu_id')->map(function ($group) {
                // Hanya hitung rata-rata dari jenis nilai akademik
                $akademik = $group->whereIn('jenis_nilai', [
                    'p_tugas', 'p_uh', 'p_uts', 'p_uas', 
                    'k_praktik', 'k_proyek', 'k_portofolio'
                ]);
                return $akademik->isNotEmpty() ? $akademik->avg('skor') : null;
            })->filter();

            $siswa->rata_rata = $nilaiPerMapel->isNotEmpty() ? round($nilaiPerMapel->avg(), 1) : null;

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

        $kelasListQuery = Kelas::orderBy('nama_kelas');
        if (!$user->isAdmin() && $user->isWaliKelas()) {
            $managedKelasIds = WaliKelas::where('guru_id', $user->guru_id)->pluck('kelas_id')->toArray();
            $kelasListQuery->whereIn('id', $managedKelasIds);
        }
        $kelasList = $kelasListQuery->get();

        return view('pages.data_rapor', compact('siswaData', 'kelasList'));
    }

    public function saveCatatan(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'catatan' => 'nullable|string'
        ]);

        $semesterAktif = Semester::where('is_aktif', true)->first();
        if (!$semesterAktif) {
            return redirect()->back()->with('error', 'Semester aktif tidak ditemukan.');
        }

        $kelasSiswa = KelasSiswa::where('siswa_id', $request->siswa_id)
            ->where('semester_id', $semesterAktif->id)
            ->first();

        if (!$kelasSiswa) {
            return redirect()->back()->with('error', 'Data penempatan siswa tidak ditemukan.');
        }

        // Otorisasi Wali Kelas via Tabel WaliKelas
        $user = auth()->user();
        $isAuthorized = WaliKelas::where('guru_id', $user->guru_id)
            ->where('kelas_id', $kelasSiswa->kelas_id)
            ->where('semester_id', $semesterAktif->id)
            ->exists();

        if (!$user->isGuru() || !$isAuthorized) {
            return redirect()->back()->with('error', 'Akses Ditolak: Hanya Wali Kelas yang bersangkutan yang dapat memberikan catatan rapor pada semester ini.');
        }

        $kelasSiswa->update([
            'catatan_wali' => $request->catatan
        ]);

        return redirect()->back()->with('success', 'Catatan wali kelas berhasil diperbarui.');
    }
}
