<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\TahunAjaran;
use App\Models\Semester;
use App\Models\KelasSiswa;
use App\Models\Pengampu;
use App\Models\WaliKelas;
use App\Models\Nilai;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 0. MEMBERSIHKAN DATABASE (CLEAN STATE)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        $tables = [
            'user', 'guru', 'siswa', 'kelas', 'mapel', 
            'tahun_ajaran', 'semester', 'kelas_siswa', 
            'pengampu', 'wali_kelas', 'nilai'
        ];
        
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::beginTransaction();
        try {
            // 1. TAHUN AJARAN & SEMESTER
            $years = [
                '2022/2023' => false,
                '2023/2024' => false,
                '2024/2025' => true,
            ];

            $smtList = [];
            foreach ($years as $name => $active) {
                $ta = TahunAjaran::create([
                    'nama' => $name,
                    'tanggal_mulai' => explode('/', $name)[0] . '-07-15',
                    'tanggal_selesai' => explode('/', $name)[1] . '-06-20',
                    'is_aktif' => $active
                ]);

                foreach (['Ganjil', 'Genap'] as $sName) {
                    $smtList[$name][$sName] = Semester::create([
                        'tahun_ajaran_id' => $ta->id,
                        'semester' => $sName,
                        'is_aktif' => ($active && $sName == 'Ganjil')
                    ]);
                }
            }

            // 2. GURU & USER
            $guruAhmad = Guru::create(['nip' => '1001', 'nama_guru' => 'Drs. Ahmad Fauzi', 'jenis_kelamin' => 'Laki-laki', 'no_hp' => '081200001001']);
            $guruSri = Guru::create(['nip' => '1002', 'nama_guru' => 'Sri Wahyuni, S.Pd.', 'jenis_kelamin' => 'Perempuan', 'no_hp' => '081200001002']);
            $guruBambang = Guru::create(['nip' => '1003', 'nama_guru' => 'Bambang S., M.Pd.', 'jenis_kelamin' => 'Laki-laki', 'no_hp' => '081200001003']);
            $guruDewi = Guru::create(['nip' => '1004', 'nama_guru' => 'Dewi Kartika, S.Pd.', 'jenis_kelamin' => 'Perempuan', 'no_hp' => '081200001004']);

            $allGurus = [$guruAhmad, $guruSri, $guruBambang, $guruDewi];
            foreach ($allGurus as $g) {
                User::create([
                    'username' => $g->nip,
                    'nama' => $g->nama_guru,
                    'email' => strtolower(explode(' ', $g->nama_guru)[0]) . '@sekolah.sch.id',
                    'password' => Hash::make($g->nip), // Password sekarang menggunakan NIP
                    'role' => 'guru',
                    'guru_id' => $g->id
                ]);
            }
            User::create([
                'username' => 'admin',
                'nama' => 'Administrator',
                'email' => 'admin@sekolah.sch.id',
                'password' => Hash::make('12345678'),
                'role' => 'admin'
            ]);

            // 3. KELAS
            $k10 = Kelas::create(['kode_kelas' => 'X-MIPA-1', 'nama_kelas' => 'X MIPA 1', 'tingkat' => 'X']);
            $k11 = Kelas::create(['kode_kelas' => 'XI-MIPA-1', 'nama_kelas' => 'XI MIPA 1', 'tingkat' => 'XI']);
            $k12 = Kelas::create(['kode_kelas' => 'XII-MIPA-1', 'nama_kelas' => 'XII MIPA 1', 'tingkat' => 'XII']);

            // 4. WALI KELAS
            foreach ($smtList as $yearSmt) {
                foreach ($yearSmt as $smt) {
                    WaliKelas::create(['kelas_id' => $k10->id, 'semester_id' => $smt->id, 'guru_id' => $guruBambang->id]);
                    WaliKelas::create(['kelas_id' => $k11->id, 'semester_id' => $smt->id, 'guru_id' => $guruSri->id]);
                    WaliKelas::create(['kelas_id' => $k12->id, 'semester_id' => $smt->id, 'guru_id' => $guruAhmad->id]);
                }
            }

            // 5. MAPEL
            $mtk = Mapel::create(['kode_mapel' => 'MTK', 'nama_mapel' => 'Matematika', 'kelompok' => 'Wajib']);
            $bin = Mapel::create(['kode_mapel' => 'BIN', 'nama_mapel' => 'Bahasa Indonesia', 'kelompok' => 'Wajib']);

            // 6. DATA SISWA (REAL NAMES)
            $studentNames = [
                2022 => ['Budi Santoso', 'Citra Lestari', 'Dedi Kurniawan'],
                2023 => ['Eka Saputra', 'Fani Rahmawati', 'Gani Ramadhan'],
                2024 => ['Hadi Wijaya', 'Indah Permata', 'Joko Susilo']
            ];

            $students = [];
            foreach ($studentNames as $year => $names) {
                foreach ($names as $i => $name) {
                    $nis = $year . "00" . ($i + 1);
                    $students[$year][] = Siswa::create([
                        'nis' => $nis,
                        'angkatan' => $year,
                        'nama_siswa' => $name, 
                        'jenis_kelamin' => ($name == 'Citra Lestari' || $name == 'Fani Rahmawati' || $name == 'Indah Permata') ? 'Perempuan' : 'Laki-laki', 
                        'status' => 'Aktif'
                    ]);
                }
            }

            // 7. PENEMPATAN KELAS
            // 2022/2023: Angkatan 2022 di Kelas 10
            foreach ($students[2022] as $s) {
                KelasSiswa::create(['siswa_id' => $s->id, 'semester_id' => $smtList['2022/2023']['Ganjil']->id, 'kelas_id' => $k10->id]);
                KelasSiswa::create(['siswa_id' => $s->id, 'semester_id' => $smtList['2022/2023']['Genap']->id, 'kelas_id' => $k10->id]);
            }

            // 2023/2024: Angkatan 2022 ke 11, Angkatan 2023 ke 10
            foreach ($students[2022] as $s) {
                KelasSiswa::create(['siswa_id' => $s->id, 'semester_id' => $smtList['2023/2024']['Ganjil']->id, 'kelas_id' => $k11->id]);
                KelasSiswa::create(['siswa_id' => $s->id, 'semester_id' => $smtList['2023/2024']['Genap']->id, 'kelas_id' => $k11->id]);
            }
            foreach ($students[2023] as $s) {
                KelasSiswa::create(['siswa_id' => $s->id, 'semester_id' => $smtList['2023/2024']['Ganjil']->id, 'kelas_id' => $k10->id]);
                KelasSiswa::create(['siswa_id' => $s->id, 'semester_id' => $smtList['2023/2024']['Genap']->id, 'kelas_id' => $k10->id]);
            }

            // 2024/2025: Angkatan 2022 ke 12, Angkatan 2023 ke 11, Angkatan 2024 ke 10
            foreach ($students[2022] as $s) {
                KelasSiswa::create(['siswa_id' => $s->id, 'semester_id' => $smtList['2024/2025']['Ganjil']->id, 'kelas_id' => $k12->id]);
            }
            foreach ($students[2023] as $s) {
                KelasSiswa::create(['siswa_id' => $s->id, 'semester_id' => $smtList['2024/2025']['Ganjil']->id, 'kelas_id' => $k11->id]);
            }
            foreach ($students[2024] as $s) {
                KelasSiswa::create(['siswa_id' => $s->id, 'semester_id' => $smtList['2024/2025']['Ganjil']->id, 'kelas_id' => $k10->id]);
            }

            // 8. PENGAMPU & NILAI
            $smtAktif = $smtList['2024/2025']['Ganjil'];
            $pengampuMtk = Pengampu::create([
                'guru_id' => $guruAhmad->id, 'mapel_id' => $mtk->id, 'kelas_id' => $k12->id, 'semester_id' => $smtAktif->id, 'kkm' => 75, 'status' => 'Aktif'
            ]);

            $ksXII = KelasSiswa::where('kelas_id', $k12->id)->where('semester_id', $smtAktif->id)->get();
            foreach ($ksXII as $ks) {
                Nilai::create([
                    'kelas_siswa_id' => $ks->id, 'pengampu_id' => $pengampuMtk->id, 'jenis_nilai' => 'UTS', 'skor' => rand(75, 95), 'catatan_guru' => 'Sangat baik, tingkatkan terus.'
                ]);
            }

            DB::commit();
            $this->command->info('✅ Seeder dengan Nama Realistis Berhasil Diterapkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('❌ Gagal: ' . $e->getMessage());
        }
    }
}
