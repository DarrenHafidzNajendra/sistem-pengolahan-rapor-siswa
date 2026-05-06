<?php

namespace App\Http\Controllers;

use App\Models\Pengampu;
use App\Models\Nilai;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\KelasSiswa;
use App\Models\Semester;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InputNilaiController extends Controller
{
    public function showInputNilai(Request $request)
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
             return redirect()->route('input_nilai')->with('error', 'Anda tidak memiliki otoritas untuk mengakses data ini.');
        }

        $siswaList = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 20);
        $siswaJsonData = collect([]);

        if ($selectedPengampu && $semesterAktif) {
            // Ambil KelasSiswa (Bridge antara Siswa, Kelas, dan Semester)
            $siswaList = Siswa::whereHas('kelasSiswa', function($q) use ($selectedPengampu, $semesterAktif) {
                    $q->where('kelas_id', $selectedPengampu->kelas_id)
                      ->where('semester_id', $semesterAktif->id);
                })
                ->orderBy('nama_siswa')
                ->paginate(20)
                ->withQueryString();

            $siswaIds = collect($siswaList->items())->pluck('id');
            
            $kelasSiswaMap = KelasSiswa::whereIn('siswa_id', $siswaIds)
                ->where('kelas_id', $selectedPengampu->kelas_id)
                ->where('semester_id', $semesterAktif->id)
                ->get()
                ->keyBy('siswa_id');

            $kelasSiswaIds = $kelasSiswaMap->pluck('id');

            // Ambil Nilai Vertikal dan kelompokkan
            $nilaiGrouped = Nilai::where('pengampu_id', $selectedPengampu->id)
                ->whereIn('kelas_siswa_id', $kelasSiswaIds)
                ->get()
                ->groupBy('kelas_siswa_id');

            $siswaJsonData = collect($siswaList->items())->map(function ($s) use ($kelasSiswaMap, $nilaiGrouped) {
                $ks = $kelasSiswaMap->get($s->id);
                $nSiswa = $nilaiGrouped->get($ks->id) ?? collect([]);
                
                // Helper to get score by type
                $getSkor = fn($type) => $nSiswa->firstWhere('jenis_nilai', $type)?->skor;
                $getCatatan = fn() => $nSiswa->firstWhere('jenis_nilai', 'catatan')?->catatan_guru;

                // Hitung Rata-rata (Manual karena data vertikal)
                $p_vals = array_filter([$getSkor('p_tugas'), $getSkor('p_uh'), $getSkor('p_uts'), $getSkor('p_uas')], fn($v) => $v !== null);
                $p_avg = count($p_vals) > 0 ? round(array_sum($p_vals) / count($p_vals), 2) : null;

                $k_vals = array_filter([$getSkor('k_praktik'), $getSkor('k_proyek'), $getSkor('k_portofolio')], fn($v) => $v !== null);
                $k_avg = count($k_vals) > 0 ? round(array_sum($k_vals) / count($k_vals), 2) : null;

                // Konversi Skor Sikap kembali ke Huruf (4=A, 3=B, 2=C, 1=D)
                $numToChar = [4 => 'A', 3 => 'B', 2 => 'C', 1 => 'D', 0 => 'B'];
                
                return [
                    'id' => $s->id,
                    'nis' => $s->nis,
                    'nama' => $s->nama_siswa,
                    'p_tugas' => $getSkor('p_tugas'),
                    'p_uh' => $getSkor('p_uh'),
                    'p_uts' => $getSkor('p_uts'),
                    'p_uas' => $getSkor('p_uas'),
                    'p_avg' => $p_avg,
                    'p_pred' => Nilai::hitungPredikat($p_avg),
                    'k_praktik' => $getSkor('k_praktik'),
                    'k_proyek' => $getSkor('k_proyek'),
                    'k_portofolio' => $getSkor('k_portofolio'),
                    'k_avg' => $k_avg,
                    'k_pred' => Nilai::hitungPredikat($k_avg),
                    's_spiritual' => $numToChar[(int)$getSkor('s_spiritual')] ?? 'B',
                    's_sosial' => $numToChar[(int)$getSkor('s_sosial')] ?? 'B',
                    'catatan' => $getCatatan() ?? '',
                ];
            })->values();
        }

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

        $pengampu = Pengampu::findOrFail($request->pengampu_id);
        $semesterId = $pengampu->semester_id;
        $dataNilai = $request->input('nilai');

        DB::transaction(function() use ($pengampu, $semesterId, $dataNilai) {
            foreach ($dataNilai as $siswaId => $fields) {
                // Cari context riwayat kelas siswa
                $ks = KelasSiswa::where('siswa_id', $siswaId)
                    ->where('kelas_id', $pengampu->kelas_id)
                    ->where('semester_id', $semesterId)
                    ->first();

                if (!$ks) continue;

                // Daftar jenis nilai yang akan disimpan
                $mapTypes = [
                    'p_tugas' => $fields['p_tugas'] ?? null,
                    'p_uh'    => $fields['p_uh'] ?? null,
                    'p_uts'   => $fields['p_uts'] ?? null,
                    'p_uas'   => $fields['p_uas'] ?? null,
                    'k_praktik' => $fields['k_praktik'] ?? null,
                    'k_proyek'  => $fields['k_proyek'] ?? null,
                    'k_portofolio' => $fields['k_portofolio'] ?? null,
                ];

                // Simpan Nilai Akademik
                foreach ($mapTypes as $type => $value) {
                    if ($value !== null) {
                        Nilai::updateOrCreate(
                            ['kelas_siswa_id' => $ks->id, 'pengampu_id' => $pengampu->id, 'jenis_nilai' => $type],
                            ['skor' => $value]
                        );
                    }
                }

                // Simpan Nilai Sikap (Convert Huruf ke Angka: A=4, B=3, C=2, D=1)
                $charToNum = ['A' => 4, 'B' => 3, 'C' => 2, 'D' => 1];
                $sikapTypes = ['s_spiritual', 's_sosial'];
                foreach ($sikapTypes as $type) {
                    if (isset($fields[$type])) {
                        Nilai::updateOrCreate(
                            ['kelas_siswa_id' => $ks->id, 'pengampu_id' => $pengampu->id, 'jenis_nilai' => $type],
                            ['skor' => $charToNum[$fields[$type]] ?? 3]
                        );
                    }
                }

                // Simpan Catatan (sebagai jenis_nilai khusus)
                if (isset($fields['catatan'])) {
                    Nilai::updateOrCreate(
                        ['kelas_siswa_id' => $ks->id, 'pengampu_id' => $pengampu->id, 'jenis_nilai' => 'catatan'],
                        ['catatan_guru' => $fields['catatan'], 'skor' => 0]
                    );
                }
            }
        });

        return redirect()->back()->with([
            'success' => 'Data nilai siswa berhasil disimpan dengan struktur vertikal (Normalized).',
            'active_tab' => $request->active_tab
        ]);
    }
}
