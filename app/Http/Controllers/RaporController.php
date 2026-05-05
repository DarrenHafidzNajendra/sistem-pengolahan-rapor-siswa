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
                // Guru adalah Wali Kelas, batasi hanya untuk kelas yang dia ampu
                $managedKelasIds = $user->managedKelas()->pluck('id')->toArray();
                
                $query->whereHas('kelasSiswa', function ($q) use ($managedKelasIds, $semesterAktif) {
                    $q->whereIn('kelas_id', $managedKelasIds);
                    if ($semesterAktif) {
                        $q->where('semester_id', $semesterAktif->id);
                    }
                });
            } else {
                // Guru bukan Wali Kelas, tidak boleh melihat data rapor
                $query->whereRaw('1 = 0'); // Menghasilkan hasil kosong secara aman
            }
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

        $kelasList = Kelas::orderBy('nama_kelas');
        
        if (!$user->isAdmin() && $user->isWaliKelas()) {
            $kelasList->whereIn('id', $user->managedKelas()->pluck('id')->toArray());
        }

        $kelasList = $kelasList->get();

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

        $kelasSiswa = \App\Models\KelasSiswa::where('siswa_id', $request->siswa_id)
            ->where('semester_id', $semesterAktif->id)
            ->first();

        if (!$kelasSiswa) {
            return redirect()->back()->with('error', 'Data penempatan siswa tidak ditemukan.');
        }

        // Cek otorisasi mutlak: Hanya Wali Kelas dari kelas tersebut yang bisa simpan (Admin pun diblokir sesuai permintaan)
        $user = auth()->user();
        $kelas = Kelas::find($kelasSiswa->kelas_id);
        if (!$user->isGuru() || !$kelas || $kelas->wali_id !== $user->guru_id) {
            return redirect()->back()->with('error', 'Akses Ditolak: Hanya Wali Kelas yang bersangkutan yang dapat memberikan catatan rapor.');
        }

        $kelasSiswa->update([
            'catatan_wali' => $request->catatan
        ]);

        return redirect()->back()->with('success', 'Catatan wali kelas berhasil diperbarui.');
    }
}
