<?php

namespace App\Http\Controllers;

use App\Models\Pengampu;
use App\Models\Presensi;
use App\Models\KelasSiswa;
use App\Models\Mapel;
use App\Models\Kelas;
use App\Models\Semester;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    public function showPresensi(Request $request)
    {
        $semesterAktif = Semester::where('is_aktif', true)->first();

        // Daftar pengampu untuk dropdown
        $pengampuList = Pengampu::with(['mapel', 'kelas'])
            ->when($semesterAktif, fn($q) => $q->where('semester_id', $semesterAktif->id))
            ->where('status', 'Aktif')
            ->get();

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

        $tanggal = $request->get('tanggal', now()->format('Y-m-d'));

        // Ambil daftar siswa + presensi
        $presensiList = collect();
        if ($selectedPengampu && $semesterAktif) {
            $siswaIds = KelasSiswa::where('kelas_id', $selectedPengampu->kelas_id)
                ->where('semester_id', $semesterAktif->id)
                ->pluck('siswa_id');

            $presensiMap = Presensi::where('pengampu_id', $selectedPengampu->id)
                ->where('tanggal', $tanggal)
                ->whereIn('siswa_id', $siswaIds)
                ->get()
                ->keyBy('siswa_id');

            $presensiList = \App\Models\Siswa::whereIn('id', $siswaIds)
                ->orderBy('nama_siswa')
                ->get()
                ->map(function ($siswa) use ($presensiMap) {
                    $p = $presensiMap->get($siswa->id);
                    $siswa->presensi_status = $p ? $p->status : 'hadir';
                    $siswa->presensi_keterangan = $p ? $p->keterangan : '';
                    return $siswa;
                });
        }

        // Pre-build JSON-safe array for Alpine.js
        $presensiJsonData = $presensiList->map(function ($s) {
            return [
                'nis' => $s->nis,
                'nama' => $s->nama_siswa,
                'status' => $s->presensi_status,
                'ket' => $s->presensi_keterangan ?? '',
            ];
        })->values();

        return view('pages.presensi', compact(
            'pengampuList',
            'mapelList',
            'kelasList',
            'selectedPengampu',
            'tanggal',
            'presensiList',
            'presensiJsonData'
        ));
    }
}
