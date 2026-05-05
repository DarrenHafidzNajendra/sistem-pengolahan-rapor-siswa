<?php

namespace App\Http\Controllers;

use App\Models\Pengampu;
use App\Models\Nilai;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\KelasSiswa;
use App\Models\Semester;
use Illuminate\Http\Request;

class InputNilaiController extends Controller
{
    public function showInputNilai(Request $request)
    {
        $semesterAktif = Semester::where('is_aktif', true)->first();

        // Ambil data user guru yang sedang login
        $user = auth()->user();

        // Ambil daftar pengampu untuk dropdown (hanya milik guru tersebut)
        $pengampuList = Pengampu::with(['mapel', 'kelas'])
            ->when($semesterAktif, fn($q) => $q->where('semester_id', $semesterAktif->id))
            ->where('guru_id', $user->guru_id) // Filter mutlak berdasarkan guru_id user
            ->where('status', 'Aktif')
            ->get();

        // Ambil daftar mapel & kelas unik dari pengampu milik guru tersebut
        $mapelList = $pengampuList->pluck('mapel')->unique('id')->values();
        $kelasList = $pengampuList->pluck('kelas')->unique('id')->values();

        // Pilih pengampu berdasarkan form filter
        $mapelId = $request->get('mapel_id');
        $kelasId = $request->get('kelas_id');

        if ($mapelId && $kelasId) {
            $selectedPengampu = $pengampuList->where('mapel_id', $mapelId)
                                           ->where('kelas_id', $kelasId)
                                           ->first();
        } else {
            $selectedPengampuId = $request->get('pengampu_id', $pengampuList->first()?->id);
            $selectedPengampu = $pengampuList->firstWhere('id', $selectedPengampuId);
        }

        // Jika mencoba mengakses pengampu_id yang bukan miliknya (lewat URL), batalkan akses
        if ($request->filled('pengampu_id') && !$selectedPengampu) {
             return redirect()->route('input_nilai')->with('error', 'Anda tidak memiliki otoritas untuk mengakses data ini.');
        }

        // Ambil siswa di kelas tersebut + nilai mereka
        $siswaList = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 20);
        if ($selectedPengampu && $semesterAktif) {
            $kelasId = $selectedPengampu->kelas_id;

            $siswaIds = KelasSiswa::where('kelas_id', $kelasId)
                ->where('semester_id', $semesterAktif->id)
                ->pluck('siswa_id');

            $nilaiMap = Nilai::where('pengampu_id', $selectedPengampu->id)
                ->whereIn('siswa_id', $siswaIds)
                ->get()
                ->keyBy('siswa_id');

            $siswaList = \App\Models\Siswa::whereIn('id', $siswaIds)
                ->orderBy('nama_siswa')
                ->paginate(20)
                ->withQueryString();

            $siswaList->getCollection()->transform(function ($siswa) use ($nilaiMap) {
                $nilai = $nilaiMap->get($siswa->id);
                $siswa->nilai = $nilai;
                return $siswa;
            });
        }

        // Pre-build JSON-safe array for Alpine.js
        $siswaJsonData = collect($siswaList->items())->map(function ($s) {
            $nilai = $s->nilai;
            return [
                'id' => $s->id,
                'nis' => $s->nis,
                'nama' => $s->nama_siswa,
                'p_tugas' => $nilai?->tugas,
                'p_uh' => $nilai?->ulangan_harian,
                'p_uts' => $nilai?->uts,
                'p_uas' => $nilai?->uas,
                'p_avg' => $nilai?->rata_pengetahuan,
                'p_pred' => $nilai ? Nilai::hitungPredikat($nilai->rata_pengetahuan) : '',
                'k_praktik' => $nilai?->praktik,
                'k_proyek' => $nilai?->proyek,
                'k_portofolio' => $nilai?->portofolio,
                'k_avg' => $nilai?->rata_keterampilan,
                'k_pred' => $nilai ? Nilai::hitungPredikat($nilai->rata_keterampilan) : '',
                's_spiritual' => $nilai?->sikap_spiritual ?? 'B',
                's_sosial' => $nilai?->sikap_sosial ?? 'B',
                'catatan' => $nilai?->catatan_guru ?? '',
            ];
        })->values();

        return view('pages.input_nilai', compact(
            'pengampuList',
            'mapelList',
            'kelasList',
            'selectedPengampu',
            'siswaList',
            'siswaJsonData'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pengampu_id' => 'required|exists:pengampu,id',
            'nilai' => 'required|array',
        ]);

        $pengampuId = $request->pengampu_id;
        $dataNilai = $request->input('nilai');

        foreach ($dataNilai as $siswaId => $fields) {
            Nilai::updateOrCreate(
                [
                    'pengampu_id' => $pengampuId,
                    'siswa_id' => $siswaId,
                ],
                [
                    'tugas' => $fields['p_tugas'] ?? null,
                    'ulangan_harian' => $fields['p_uh'] ?? null,
                    'uts' => $fields['p_uts'] ?? null,
                    'uas' => $fields['p_uas'] ?? null,
                    'praktik' => $fields['k_praktik'] ?? null,
                    'proyek' => $fields['k_proyek'] ?? null,
                    'portofolio' => $fields['k_portofolio'] ?? null,
                    'sikap_spiritual' => $fields['s_spiritual'] ?? 'B',
                    'sikap_sosial' => $fields['s_sosial'] ?? 'B',
                    'catatan_guru' => $fields['catatan'] ?? null,
                ]
            );
        }

        return redirect()->back()->with([
            'success' => 'Data nilai siswa berhasil diperbarui dan disimpan ke database.',
            'active_tab' => $request->active_tab
        ]);
    }
}
