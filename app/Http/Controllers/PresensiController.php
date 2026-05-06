<?php

namespace App\Http\Controllers;

use App\Models\Pengampu;
use App\Models\Presensi;
use App\Models\KelasSiswa;
use App\Models\Mapel;
use App\Models\Kelas;
use App\Models\Semester;
use App\Models\Siswa;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    public function showPresensi(Request $request)
    {
        $semesterAktif = Semester::where('is_aktif', true)->first();
        $user = auth()->user();

        $pengampuList = Pengampu::with(['mapel', 'kelas'])
            ->when($semesterAktif, fn($q) => $q->where('semester_id', $semesterAktif->id))
            ->where('guru_id', $user->guru_id)
            ->where('status', 'Aktif')
            ->get();

        $mapelList = $pengampuList->pluck('mapel')->unique('id')->values();
        $kelasList = $pengampuList->pluck('kelas')->unique('id')->values();

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

        if ($request->filled('pengampu_id') && !$selectedPengampu) {
            return redirect()->route('presensi')->with('error', 'Anda tidak memiliki hak akses untuk melakukan absensi pada kelas ini.');
        }

        $tanggal = $request->get('tanggal', now()->format('Y-m-d'));

        $presensiList = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 20);

        if ($selectedPengampu && $semesterAktif) {
            $presensiList = Siswa::whereHas('kelasSiswa', function($q) use ($selectedPengampu, $semesterAktif) {
                    $q->where('kelas_id', $selectedPengampu->kelas_id)
                      ->where('semester_id', $semesterAktif->id);
                })
                ->orderBy('nama_siswa')
                ->paginate(20)
                ->withQueryString();

            $siswaIds = collect($presensiList->items())->pluck('id');
            
            $ksMap = KelasSiswa::whereIn('siswa_id', $siswaIds)
                ->where('kelas_id', $selectedPengampu->kelas_id)
                ->where('semester_id', $semesterAktif->id)
                ->get()
                ->keyBy('siswa_id');

            $ksIds = $ksMap->pluck('id');

            $presensiMap = Presensi::where('pengampu_id', $selectedPengampu->id)
                ->where('tanggal', $tanggal)
                ->whereIn('kelas_siswa_id', $ksIds)
                ->get()
                ->keyBy('kelas_siswa_id');

            // Attach presensi status to each student object for the view
            $presensiList->getCollection()->transform(function ($s) use ($ksMap, $presensiMap) {
                $ks = $ksMap->get($s->id);
                $p = $presensiMap->get($ks?->id);
                $s->presensi_status = $p ? $p->status : null;
                $s->presensi_keterangan = $p ? $p->keterangan : '';
                return $s;
            });
        }

        return view('pages.presensi', compact(
            'pengampuList',
            'mapelList',
            'kelasList',
            'selectedPengampu',
            'tanggal',
            'presensiList'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pengampu_id' => 'required|exists:pengampu,id',
            'tanggal'     => 'required|date',
            'presensi'    => 'required|array',
        ]);

        $pengampu = Pengampu::findOrFail($request->pengampu_id);
        
        if ($pengampu->guru_id !== auth()->user()->guru_id) {
            return redirect()->back()->with('error', 'Otorisasi gagal.');
        }

        foreach ($request->presensi as $siswaId => $data) {
            if (isset($data['status']) && !empty($data['status'])) {
                $ks = KelasSiswa::where('siswa_id', $siswaId)
                    ->where('kelas_id', $pengampu->kelas_id)
                    ->where('semester_id', $pengampu->semester_id)
                    ->first();

                if (!$ks) continue;

                Presensi::updateOrCreate(
                    [
                        'kelas_siswa_id' => $ks->id,
                        'pengampu_id'    => $pengampu->id,
                        'tanggal'        => $request->tanggal,
                    ],
                    [
                        'status'     => $data['status'],
                        'keterangan' => $data['ket'] ?? '',
                    ]
                );
            }
        }

        return redirect()->back()->with('success', 'Data presensi berhasil disimpan.');
    }
}
