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
use App\Models\Nilai;
use App\Models\Presensi;
use App\Models\WaliKelas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::beginTransaction();
        try {
            // =============================================
            // 1. TAHUN AJARAN & SEMESTER
            // =============================================
            $ta = TahunAjaran::create([
                'nama' => '2025/2026',
                'tanggal_mulai' => '2025-07-14',
                'tanggal_selesai' => '2026-06-20',
                'is_aktif' => true,
            ]);

            $smtGenap = Semester::create([
                'tahun_ajaran_id' => $ta->id,
                'semester' => 'Genap',
                'is_aktif' => true,
            ]);

            // =============================================
            // 2. GURU
            // =============================================
            $guruData = [
                ['nip' => '198501012010011001', 'nama_guru' => 'Drs. Ahmad Fauzi, M.Pd.',    'jenis_kelamin' => 'Laki-laki',  'no_hp' => '081234567801'],
                ['nip' => '198602022011012002', 'nama_guru' => 'Sri Wahyuni, S.Pd.',           'jenis_kelamin' => 'Perempuan',  'no_hp' => '081234567802'],
                ['nip' => '198703032012011003', 'nama_guru' => 'Bambang Supriyadi, S.Pd.',     'jenis_kelamin' => 'Laki-laki',  'no_hp' => '081234567803'],
                ['nip' => '198804042013012004', 'nama_guru' => 'Dewi Kartika Sari, M.Pd.',     'jenis_kelamin' => 'Perempuan',  'no_hp' => '081234567804'],
            ];

            $gurus = [];
            foreach ($guruData as $g) {
                $gurus[] = Guru::create($g);
            }

            // =============================================
            // 3. USER
            // =============================================
            User::create([
                'nama' => 'Administrator',
                'username' => '12345678',
                'email' => 'admin@sekolah.sch.id',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
            ]);

            foreach ($gurus as $guru) {
                User::create([
                    'nama' => $guru->nama_guru,
                    'username' => $guru->nip,
                    'email' => strtolower(explode(' ', $guru->nama_guru)[0]) . '@sekolah.sch.id',
                    'password' => Hash::make($guru->nip),
                    'role' => 'guru',
                    'guru_id' => $guru->id,
                ]);
            }

            // =============================================
            // 4. KELAS & WALI KELAS (Histori)
            // =============================================
            $kelasData = [
                ['kode_kelas' => 'X-MIPA-1',  'nama_kelas' => 'X MIPA 1',    'tingkat' => 'X'],
                ['kode_kelas' => 'X-MIPA-2',  'nama_kelas' => 'X MIPA 2',    'tingkat' => 'X'],
                ['kode_kelas' => 'XI-MIPA-1', 'nama_kelas' => 'XI MIPA 1',   'tingkat' => 'XI'],
            ];

            $kelasList = [];
            foreach ($kelasData as $i => $k) {
                $kelas = Kelas::create($k);
                $kelasList[] = $kelas;
                
                // Assign Wali Kelas via Bridge Table (Normalized)
                WaliKelas::create([
                    'guru_id' => $gurus[$i]->id,
                    'kelas_id' => $kelas->id,
                    'semester_id' => $smtGenap->id
                ]);
            }

            // =============================================
            // 5. MAPEL
            // =============================================
            $mapelList = [
                Mapel::create(['kode_mapel' => 'MTK', 'nama_mapel' => 'Matematika', 'kelompok' => 'Wajib']),
                Mapel::create(['kode_mapel' => 'BIN', 'nama_mapel' => 'Bahasa Indonesia', 'kelompok' => 'Wajib']),
            ];

            // =============================================
            // 6. SISWA
            // =============================================
            $siswaList = [];
            for ($i = 1; $i <= 10; $i++) {
                $siswaList[] = Siswa::create([
                    'nis' => '202500' . $i,
                    'nama_siswa' => 'Siswa Contoh ' . $i,
                    'jenis_kelamin' => $i % 2 == 0 ? 'Perempuan' : 'Laki-laki',
                    'status' => 'Aktif'
                ]);
            }

            // =============================================
            // 7. KELAS_SISWA (Penempatan)
            // =============================================
            $ksList = [];
            foreach ($siswaList as $index => $siswa) {
                $kelasIdx = $index < 5 ? 0 : 1; // 5 pertama di X MIPA 1, sisanya X MIPA 2
                $ksList[] = KelasSiswa::create([
                    'siswa_id' => $siswa->id,
                    'kelas_id' => $kelasList[$kelasIdx]->id,
                    'semester_id' => $smtGenap->id
                ]);
            }

            // =============================================
            // 8. PENGAMPU
            // =============================================
            $pengampuList = [
                Pengampu::create([
                    'guru_id' => $gurus[0]->id,
                    'mapel_id' => $mapelList[0]->id,
                    'kelas_id' => $kelasList[0]->id,
                    'semester_id' => $smtGenap->id,
                    'kkm' => 75
                ]),
                Pengampu::create([
                    'guru_id' => $gurus[1]->id,
                    'mapel_id' => $mapelList[1]->id,
                    'kelas_id' => $kelasList[0]->id,
                    'semester_id' => $smtGenap->id,
                    'kkm' => 75
                ]),
            ];

            // =============================================
            // 9. NILAI (Vertikal)
            // =============================================
            $jenisNilai = ['p_tugas', 'p_uh', 'p_uts', 'p_uas', 'k_praktik', 's_spiritual', 's_sosial'];
            
            foreach ($ksList as $ks) {
                // Hanya isi nilai untuk siswa yang ada di kelas yang diampu (Kelas 0)
                if ($ks->kelas_id == $kelasList[0]->id) {
                    foreach ($pengampuList as $pengampu) {
                        foreach ($jenisNilai as $jenis) {
                            $skor = strpos($jenis, 's_') === 0 ? rand(3, 4) : rand(70, 95);
                            Nilai::create([
                                'kelas_siswa_id' => $ks->id,
                                'pengampu_id' => $pengampu->id,
                                'jenis_nilai' => $jenis,
                                'skor' => $skor
                            ]);
                        }
                        // Tambahkan catatan
                        Nilai::create([
                            'kelas_siswa_id' => $ks->id,
                            'pengampu_id' => $pengampu->id,
                            'jenis_nilai' => 'catatan',
                            'skor' => 0,
                            'catatan_guru' => 'Siswa menunjukkan perkembangan yang sangat baik.'
                        ]);
                    }
                }
            }
            
            DB::commit();
            $this->command->info('✅ Database berhasil di-seed dengan struktur Normalized!');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('❌ Gagal seeding: ' . $e->getMessage());
        }
    }
}
