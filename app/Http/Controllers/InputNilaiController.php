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

        // Ambil daftar pengampu untuk dropdown
        $pengampuList = Pengampu::with(['mapel', 'kelas'])
            ->when($semesterAktif, fn($q) => $q->where('semester_id', $semesterAktif->id))
            ->where('status', 'Aktif')
            ->get();

        // Ambil daftar mapel & kelas unik dari pengampu aktif
        $mapelList = $pengampuList->pluck('mapel')->unique('id')->values();
        $kelasList = $pengampuList->pluck('kelas')->unique('id')->values();

        // Pilih pengampu berdasarkan form filter
        $mapelId = $request->get('mapel_id');
        $kelasId = $request->get('kelas_id');

        if ($mapelId && $kelasId) {
            $selectedPengampu = $pengampuList->firstWhere(function ($p) use ($mapelId, $kelasId) {
                return $p->mapel_id == $mapelId && $p->kelas_id == $kelasId;
            });
        } else {
            $selectedPengampuId = $request->get('pengampu_id', $pengampuList->first()?->id);
            $selectedPengampu = $pengampuList->firstWhere('id', $selectedPengampuId);
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
}
